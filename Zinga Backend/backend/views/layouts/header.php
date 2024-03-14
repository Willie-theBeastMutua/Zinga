<?php
$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;
?>
<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
		<div class="navbar-wrapper">
			<div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item mr-auto"><a class="navbar-brand" href="<?= $baseUrl; ?>">
                        <img class="brand-logo" alt="" src="<?= $baseUrl; ?>/app-assets/images/logo/logo1.png">
                            <h3 class="brand-text">Admin</h3>
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
                    <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="material-icons mt-1">more_vert</i></a></li>
                </ul>
			</div>
			
			<div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <ul class="nav navbar-nav mr-auto float-left">							
                        <li class="nav-item d-none d-lg-block d-none">
                            <a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
                        <li class="dropdown nav-item mega-dropdown d-lg-block d-none"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">NAWIRI</a>
                
                        </li>
                    </ul>
                    
                        <ul class="nav navbar-nav float-right">							
                            <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="mr-1 user-name text-bold-700"><?= $user->firstName . ' ' . $user->lastName; ?></span><span class="avatar avatar-online"><img src="<?= $baseUrl; ?>/app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="<?= $baseUrl; ?>/profile/view"><i class="material-icons">person_outline</i> Edit Profile</a>
                                    <?php if (in_array(22, $rights)) { ?>
                                        <a class="dropdown-item" href="<?= $baseUrl; ?>/company/view"><i class="material-icons">person_outline</i> Company Details</a>
                                        <?php
                                    } ?>
                                    <a class="dropdown-item" href="<?= $baseUrl; ?>/site/change-password"><i class="material-icons">lock_open</i> Change Password</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= $baseUrl; ?>/site/logout"><i class="material-icons">power_settings_new</i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
			</div>
			
		</div>
	</nav>
	<!-- END: Header-->