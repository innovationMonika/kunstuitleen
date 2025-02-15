/**
 * External dependencies
 */
import { Link } from 'react-router-dom';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useDispatch, useSelect } from '@wordpress/data';
import { gmdate } from '@wordpress/date';
import { Flex } from '@wordpress/components';

/**
 * Solid dependencies
 */
import { Button, Text, TextWeight } from '@ithemes/ui';

/**
 * Internal dependencies
 */
import { firewallStore, coreStore, vulnerabilitiesStore } from '@ithemes/security.packages.data';
import { withNavigate } from '@ithemes/security-hocs';
import { getSelf } from '@ithemes/security-utils';
import { EmptyStateBasic, EmptyStateProHasVulnerabilities, EmptyStatePro } from '../empty-states';
import RuleProvider from '../rule-provider';
import { StyledActionsButton } from './styles';

export default function RulesTable() {
	const { rules, hasResolved, installType, hasVulnerabilities } = useSelect( ( select ) => ( {
		rules: select( firewallStore ).getFirewallRules(),
		hasResolved: select( firewallStore ).hasFinishedResolution( 'getFirewallRules' ),
		installType: select( coreStore ).getInstallType(),
		hasVulnerabilities: select( vulnerabilitiesStore ).getVulnerabilities().length > 0,
	} ), [] );

	const emptyState = ! rules.length && hasResolved;

	return (
		<table className="itsec-firewall-rules-table">
			<thead>
				<tr>
					<Text as="th" text={ __( 'Title', 'it-l10n-ithemes-security-pro' ) } />
					<Text as="th" text={ __( 'Source', 'it-l10n-ithemes-security-pro' ) } />
					<Text as="th" text={ __( 'Status', 'it-l10n-ithemes-security-pro' ) } />
					<Text as="th" text={ __( 'Action', 'it-l10n-ithemes-security-pro' ) } />
				</tr>
			</thead>
			<tbody>
				{ rules?.map( ( rule ) => <Rule key={ rule.id } rule={ rule } /> ) }

				{ emptyState && installType === 'free' && (
					<tr>
						<td colSpan={ 4 }><EmptyStateBasic /></td>
					</tr>
				) }

				{ emptyState && installType === 'pro' && hasVulnerabilities && (
					<tr>
						<td colSpan={ 4 }>
							<EmptyStateProHasVulnerabilities />
						</td>
					</tr>
				) }

				{ emptyState && installType === 'pro' && ! hasVulnerabilities && (
					<tr>
						<td colSpan={ 4 }>
							<EmptyStatePro />
						</td>
					</tr>
				) }

			</tbody>
		</table>
	);
}

function Rule( { rule } ) {
	const { isSaving, isDeleting } = useSelect( ( select ) => ( {
		isSaving: select( firewallStore ).isSaving( rule ),
		isDeleting: select( firewallStore ).isDeleting( rule ),
	} ), [ rule ] );
	const { saveItem, deleteItem } = useDispatch( firewallStore );
	const onTogglePause = () => {
		saveItem( {
			...rule,
			paused_at: rule.paused_at ? null : gmdate( 'Y-m-d\\TH:i:s' ),
		} );
	};

	return (
		<tr>
			<td>
				<Text weight={ TextWeight.HEAVY }>
					{ rule.name }
				</Text>
			</td>
			<td><RuleProvider provider={ rule.provider } /></td>
			<td><Text text={ rule.paused_at ? __( 'Inactive', 'it-l10n-ithemes-security-pro' ) : __( 'Active', 'it-l10n-ithemes-security-pro' ) } /></td>
			<td>
				<Flex justify="start">
					<StyledActionsButton
						onClick={ onTogglePause }
						isBusy={ isSaving }
						isActive={ rule.paused_at }
						text={ rule.paused_at ? __( 'Activate', 'it-l10n-ithemes-security-pro' ) : __( 'Deactivate', 'it-l10n-ithemes-security-pro' ) }
					/>
					{ rule.provider === 'user' && (
						<>
							<Link
								to={ `/rules/${ rule.id }` }
								component={ withNavigate( Button ) }
								text={ __( 'Edit', 'it-l10n-ithemes-security-pro' ) }
							/>
							<Button
								onClick={ () => deleteItem( getSelf( rule ) ) }
								isDestructive
								isBusy={ isDeleting }
								text={ __( 'Delete', 'it-l10n-ithemes-security-pro' ) }
							/>
						</>
					) }
				</Flex>
			</td>
		</tr>
	);
}
