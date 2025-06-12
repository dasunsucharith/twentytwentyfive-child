<?php

/**
 * Title: Enhanced Header
 * Slug: twentytwentyfive-child/enhanced-header
 * Categories: header
 * Block Types: core/template-part/header
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","right":"0","bottom":"0","left":"0"},"margin":{"top":"0","bottom":"0"}},"position":{"type":"sticky","top":"0px"}},"className":"enhanced-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull enhanced-header" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">
	<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"1rem","bottom":"1rem","left":"2rem","right":"2rem"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"}} -->
	<div class="wp-block-group alignwide" style="padding-top:1rem;padding-bottom:1rem;padding-left:2rem;padding-right:2rem">

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
		<div class="wp-block-group">
			<!-- wp:site-logo {"width":50,"shouldSyncIcon":false} /-->
			<!-- wp:site-title {"level":0,"style":{"typography":{"fontStyle":"normal","fontWeight":"600","fontSize":"1.8rem"},"spacing":{"margin":{"left":"1.5rem"}}}} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:navigation {"ref":4,"overlayMenu":"mobile","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"right","orientation":"horizontal"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
		<!-- wp:page-list /-->
		<!-- /wp:navigation -->

	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->