/**
 * External dependencies
 */
import memize from 'memize';
import { without, some, get } from 'lodash';

/**
 * WordPress dependencies
 */
import { useSelect, useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import { HierarchicalCheckboxControl } from '@ithemes/security-components';
import { bifurcate } from '@ithemes/security-utils';
import { store as uiStore } from '@ithemes/security.user-groups.ui';

const toCanonicalGroup = memize( ( availableRoles, includeSuperAdmin ) => {
	const group = [
		{
			value: '$administrator$',
			label: __( 'Administrator Capabilities', 'it-l10n-ithemes-security-pro' ),
		},
		{
			value: '$editor$',
			label: __( 'Editor Capabilities', 'it-l10n-ithemes-security-pro' ),
		},
		{
			value: '$author$',
			label: __( 'Author Capabilities', 'it-l10n-ithemes-security-pro' ),
		},
		{
			value: '$contributor$',
			label: __( 'Contributor Capabilities', 'it-l10n-ithemes-security-pro' ),
		},
		{
			value: '$subscriber$',
			label: __( 'Subscriber Capabilities', 'it-l10n-ithemes-security-pro' ),
		},
	];

	if ( includeSuperAdmin ) {
		group.unshift( {
			value: '$super-admin$',
			label: __( 'Super Admin', 'it-l10n-ithemes-security-pro' ),
		} );
	}

	if ( some( availableRoles, ( role ) => role.canonical === '' ) ) {
		group.push( {
			value: '$other$',
			label: __( 'Other', 'it-l10n-ithemes-security-pro' ),
			selectable: false,
		} );
	}

	for ( const role in availableRoles ) {
		if ( ! availableRoles.hasOwnProperty( role ) ) {
			continue;
		}

		const { canonical, label } = availableRoles[ role ];

		group.push( {
			value: role,
			parent: canonical.length > 0 ? `$${ canonical }$` : '$other$',
			label,
		} );
	}

	return Object.values( group );
} );

export default function PanelRoles( {
	groupId,
	disabled = false,
} ) {
	const { roles, canonical, available, schema } = useSelect( ( select ) => ( {
		roles:
			select( uiStore ).getEditedGroupAttribute( groupId, 'roles' ) || [],
		canonical:
			select(	uiStore	).getEditedGroupAttribute( groupId, 'canonical' ) || [],
		available: select( 'ithemes-security/core' ).getRoles(),
		schema: select( 'ithemes-security/core' ).getSchema(
			'ithemes-security-user-group'
		),
	} ), [ groupId ] );
	const { editGroup } = useDispatch( uiStore );

	const includeSuperAdmin = get(
		schema,
		[ 'properties', 'canonical', 'items', 'enum' ],
		[]
	).includes( 'super-admin' );
	const value = [ ...roles, ...canonical.map( ( role ) => `$${ role }$` ) ];

	return (
		<HierarchicalCheckboxControl
			label={ __( 'Select Roles', 'it-l10n-ithemes-security-pro' ) }
			help={ __(
				'Add users with the selected roles to this group.',
				'it-l10n-ithemes-security-pro'
			) }
			value={ value }
			disabled={ disabled }
			options={ toCanonicalGroup( available, includeSuperAdmin ) }
			onChange={ ( change ) => {
				const [ newCanonical, newRoles ] = bifurcate(
					change,
					( role ) => role.startsWith( '$' ) && role.endsWith( '$' )
				);

				editGroup( groupId, {
					roles: newRoles,
					canonical: without(
						newCanonical.map( ( role ) => role.slice( 1, -1 ) ),
						'other'
					),
				} );
			} }
		/>
	);
}
