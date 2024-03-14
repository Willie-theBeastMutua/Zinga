<?php

$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;
use yii\helpers\ArrayHelper;

use backend\controllers\RightsController;

$currentPage = Yii::$app->controller->id;
$currentRoute = trim(Yii::$app->controller->module->requestedRoute);
$option = isset($_GET['option']) ? $_GET['option'] : '';
$cid = isset($_GET['cid']) ? $_GET['cid'] : '';

$rights = (array) RightsController::Permissions(0);

if (!empty($rights)) {
	foreach ($rights as $key => $right) {
		if (!isset($right['view']) || $right['view'] != 1) {
			unset($rights[$key]);
		}
	}
}
// print('<pre>');
// print_r($rights);
$rights = ArrayHelper::getColumn($rights, 'pageId');
// print_r($rights); exit;

?>

<!-- BEGIN: Main Menu-->

<div class="main-menu material-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
	<!-- <div class="user-profile1" style="padding: 5px; text-align: center; background-color: #F4F5FA;" >
		<img src="<?= $baseUrl; ?>/app-assets/images/logo/logo.png" width="60%">		
	</div> -->
	<div class="main-menu-content">
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
			<li <?= ($currentRoute == 'site/index' || $currentRoute == 'site') ? 'class="active"' : ''; ?> class=" nav-item"><a href="<?= $baseUrl;?>/site"><i class="material-icons">home</i><span class="menu-title" data-i18n="nav.dash.main">Home</span></a>
			</li>

            <?php if (count(array_intersect($rights, [9, 10, 11, 12, 13])) > 0) { ?>
				<li class=" nav-item"><a href="#"><i class="material-icons">person_outline</i><span class="menu-title" data-i18n="nav.project.main">Tools</span></a>
					<ul class="menu-content">
						<?php if (in_array(9, $rights)) { ?>
							<li <?= ($currentPage == 'tools') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/tools"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Tools</span></a>
							</li>
							<?php
						}
						if (in_array(10, $rights)) { ?>
							<li <?= ($currentPage == 'programmes') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/programmes"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">Programmes</span></a>
							</li>
							<?php
						}
						if (in_array(11, $rights)) { ?>
							<li <?= ($currentPage == 'tool-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/tool-status"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Tools Status</span></a>
							</li>
							<?php
						} ?>

                        <?php if (in_array(12, $rights)) { ?>
							<li <?= ($currentPage == 'material-types') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/material-types"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Material Types</span></a>
							</li>
                        <?php } ?>

                        <?php if (in_array(13, $rights)) { ?>
							<li <?= ($currentPage == 'levels') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/levels"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Levels</span></a>
							</li>
                        <?php } ?>
					</ul>
				</li>		
            <?php } ?>
			
			<?php if (count(array_intersect($rights, [5, 6, 7])) > 0) { ?>
				<li class=" nav-item"><a href="#"><i class="material-icons">contact_support</i><span class="menu-title" data-i18n="nav.project.main">Support</span></a>
					<ul class="menu-content">
						<?php if (in_array(7, $rights)) { ?>	
							<li <?= ($currentPage == 'manage-support') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/manage-support"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Manage Support</span></a>
							</li>	
							<?php
						} ?>
						<?php if (in_array(5, $rights)) { ?>	
							<li <?= ($currentPage == 'support-subjects') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/support-subjects"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Support Subjects</span></a>
							</li>
							<?php
						} ?>
						<?php if (in_array(6, $rights)) { ?>	
							<li <?= ($currentPage == 'support-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/support-status"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Support Status</span></a>
							</li>
							<?php
						} ?>		
					</ul>
				</li>	
				<?php
			} ?>

			<?php if (count(array_intersect($rights, [8, 12, 13, 21, 22, 23, 24])) > 0) { ?>
				<li class=" nav-item"><a href="#"><i class="material-icons">settings_applications</i><span class="menu-title" data-i18n="nav.project.main">Setup</span></a>
					<ul class="menu-content">
                        
						<?php if (in_array(8, $rights)) { ?>
							<li <?= ($currentPage == 'templates') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/templates"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Templates</span></a>
							</li>
							<?php
						} ?>

                        <?php if (in_array(12, $rights)) { ?>
							<li <?= ($currentPage == 'collection-centers') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/collection-centers"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Collection Centers</span></a>
							</li>
							<?php
						} ?>

                        <?php if (in_array(21, $rights)) { ?>
							<li <?= ($currentPage == 'regions') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/regions"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Regions</span></a>
							</li>
							<?php
						} ?>

                        <?php if (in_array(22, $rights)) { ?>
							<li <?= ($currentPage == 'counties') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/counties"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Counties</span></a>
							</li>
							<?php
						} ?>

                        <?php if (in_array(23, $rights)) { ?>
							<li <?= ($currentPage == 'constituencies') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/constituencies"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Constituencies</span></a>
							</li>
							<?php
						} ?>

                        <?php if (in_array(24, $rights)) { ?>
							<li <?= ($currentPage == 'wards') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/wards"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Wards</span></a>
							</li>
							<?php
						} ?>
					</ul>
				</li>
				<?php
			} ?>

			<?php if (count(array_intersect($rights, [1, 2, 3, 15])) > 0) { ?>
				<li class=" nav-item"><a href="#"><i class="material-icons">person_outline</i><span class="menu-title" data-i18n="nav.project.main">Security & Admin</span></a>
					<ul class="menu-content">
						<?php if (in_array(1, $rights)) { ?>
							<li <?= ($currentPage == 'users') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/users"><i class="material-icons"></i><span data-i18n="nav.project.project_summary">Users</span></a>
							</li>
							<?php
						}
						if (in_array(2, $rights)) { ?>
							<li <?= ($currentPage == 'user-status') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/user-status"><i class="material-icons"></i><span data-i18n="nav.project.project_tasks">User Status</span></a>
							</li>
							<?php
						}
						if (in_array(3, $rights)) { ?>
							<li <?= ($currentPage == 'user-groups') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/user-groups"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">User Groups</span></a>
							</li>
							<?php
						} 
						if (in_array(15, $rights)) { ?>
							<li <?= ($currentPage == 'user-groups') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl; ?>/pages"><i class="material-icons"></i><span data-i18n="nav.project.project_bugs">Pages</span></a>
							</li>
							<?php
						}
						
						?>
					</ul>
				</li>		
            <?php } ?>	

			<li <?= ($currentRoute == 'site/apis') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/site/apis"><i class="material-icons">api</i><span data-i18n="nav.project.project_summary">APIs</span></a>
			</li>
			<li <?= ($currentRoute == 'site/community') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/site/community"><i class="material-icons">local_library</i><span data-i18n="nav.project.project_summary">Community</span></a>
			</li>
			<li <?= ($currentRoute == 'site/about-us') ? 'class="active"' : ''; ?>><a class="menu-item" href="<?= $baseUrl;?>/site/about-us"><i class="material-icons">info</i><span data-i18n="nav.project.project_summary">About Us</span></a>
			</li>
			<li class=" navigation-header"><span data-i18n="nav.category.support">Support</span><i class="material-icons nav-menu-icon" data-toggle="tooltip" data-placement="right" data-original-title="Support">more_horiz</i>
			</li>					
				<li class="<?= ($currentRoute == 'site/support') ? 'active' : ''; ?> nav-item"><a href="<?= $baseUrl; ?>/site/support"><i class="material-icons">local_offer</i><span class="menu-title" data-i18n="nav.support_raise_support.main">Raise Support</span></a>
				</li>
				
				<!-- <li class="<?= ($currentRoute == 'site/documentation') ? 'active' : ''; ?> nav-item" <?= ($currentRoute == 'site/documentation') ? 'class="active"' : ''; ?>><a href="<?= $baseUrl; ?>/site/documentation"><i class="material-icons">format_size</i><span class="menu-title" data-i18n="nav.support_documentation.main">Documentation</span></a>
				</li> -->
		</ul>
	</div>
</div>

	<!-- END: Main Menu-->
