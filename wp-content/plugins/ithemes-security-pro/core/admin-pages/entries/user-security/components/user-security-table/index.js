/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useDispatch, useSelect } from '@wordpress/data';
import { useViewportMatch } from '@wordpress/compose';
import { VisuallyHidden } from '@wordpress/components';

/**
 * SolidWP dependencies
 */
import { Text } from '@ithemes/ui';

/**
 * Internal dependencies
 */
import {
	UserSecurityTableHeaderDropdown,
} from './user-security-table-header-dropdown';
import { userSecurityStore } from '@ithemes/security.packages.data';
import { UserTableRow } from './user-table-row';
import {
	StyledTableSection,
	StyledUserTH,
	StyledCheckboxControl,
	StyledBulkEditTH,
} from './styles';
import '../../style.scss';

export default function UserSecurityTable( ) {
	const { users, selectAllState } = useSelect(
		( select ) => ( {
			users: select( userSecurityStore ).getUsers(),
			selectedUsers: select( userSecurityStore ).getCurrentlySelectedUsers(),
			selectAllState: select( userSecurityStore ).getSelectAllState(),
		} ),
		[]
	);
	const { toggleSelectAll } = useDispatch( userSecurityStore );
	const isMedium = useViewportMatch( 'medium' );
	const isLarge = useViewportMatch( 'large' );

	return (
		<StyledTableSection as="section">
			<table className="itsec-user-security__table">
				<thead>
					<tr>
						<StyledBulkEditTH as="th">
							<StyledCheckboxControl
								checked={ selectAllState === 'checked' }
								onChange={ ( ) => {
									toggleSelectAll( 'main' );
								} }
								label={ __( 'Select all users', 'it-l10n-ithemes-security-pro' ) }
								hideLabelFromVision
								indeterminate={ selectAllState === 'indeterminate' }
							/>
							<UserSecurityTableHeaderDropdown />
							<StyledUserTH
								as="span"
								text={ __( 'User', 'it-l10n-ithemes-security-pro' ) }
								textTransform="uppercase"
							/>
						</StyledBulkEditTH>
						{ isMedium && (
							<Text
								as="th"
								text={ __( 'Role', 'it-l10n-ithemes-security-pro' ) }
								textTransform="uppercase"
							/>
						) }
						{ isLarge && (
							<Text
								as="th"
								text={ __( 'Last Seen', 'it-l10n-ithemes-security-pro' ) }
								textTransform="uppercase"
							/>
						) }
						{ isMedium && (
							<Text
								as="th"
								text={ __( 'PW Strength', 'it-l10n-ithemes-security-pro' ) }
								textTransform="uppercase"
							/>
						) }
						{ isLarge && (
							<Text
								as="th"
								text={ __( 'PW Age', 'it-l10n-ithemes-security-pro' ) }
								textTransform="uppercase"
							/>
						) }
						{ isMedium && (
							<Text
								as="th"
								text={ __( '2FA', 'it-l10n-ithemes-security-pro' ) }
							/>
						) }
						<Text
							as="th"
							text={ __( 'Actions', 'it-l10n-ithemes-security-pro' ) }
							textTransform="uppercase"
						/>
						{ ! isLarge && (
							<th>
								<VisuallyHidden>{ __( 'User Details Toggle', 'it-l10n-ithemes-security-pro' ) }</VisuallyHidden>
							</th>
						) }
					</tr>
				</thead>
				<tbody>
					{ users.map( ( user ) => (
						<UserTableRow
							key={ user.id }
							user={ user }
							isMedium={ isMedium }
							isLarge={ isLarge }
						/>
					) ) }
				</tbody>
			</table>
		</StyledTableSection>
	);
}
