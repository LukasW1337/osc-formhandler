	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<!--h2><span>Header if needed</span></h2-->

						<div class="inside">
							<p><strong>Table with class <code>widefat</code></strong></p>
<table class="widefat">
	<thead>
	<tr>
        <th>Id</th>
		<th class="row-title">Test</th>
		<th>Test2</th>
	</tr>
	</thead>
	<tbody>
	<tr>
        <td><code>1</code></td>
		<td class="row-title"><label for="tablecell">hello</label></td>
		<td>hello</td>
	</tr>
	<tr class="alternate">
        <td><code>1</code></td>
		<td class="row-title"><label for="tablecell"><?php esc_attr_e(
					'Table Cell #3, with label and class', 'WpAdminStyle'
				); ?> <code>alternate</code></label></td>
		<td><?php esc_attr_e( 'Table Cell #4', 'WpAdminStyle' ); ?></td>
	</tr>
	</tbody>
	<tfoot>
	<tr>
        <th><code>1</code></th>
		<th class="row-title"><?php esc_attr_e( 'Table header cell #1', 'WpAdminStyle' ); ?></th>
		<th><?php esc_attr_e( 'Table header cell #2', 'WpAdminStyle' ); ?></th>
	</tr>
	</tfoot>
</table>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->