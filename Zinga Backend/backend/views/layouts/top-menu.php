<?php
$baseUrl = Yii::$app->request->baseUrl;
$user = Yii::$app->user->identity;
?>
<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-semi-dark navbar-shadow">
		<div class="navbar-wrapper">	
			<div class="navbar-header1" style="background: #24498C; color: #FFFFFF; padding: 0; margin: 0">
					<ul class="nav navbar-nav flex-row">
						<!-- <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li> -->
						<!-- <li class="nav-item"><a class="navbar-brand" href="index.html"><img class="brand-logo" alt="modern admin logo" src="../../../app-assets/images/logo/logo.png"> -->
									<!-- <h3 class="brand-text">Vacko</h3> -->
							<!-- </a></li> -->
							
						<li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="ft-menu font-large-1" style="color: #FFFFFF"></i></a></li>
						
							<h3 class="brand-text">Routine Data Quality Assessments---</h3>
						
					</ul>
			</div>		
			<div class="navbar-container content">
					<div class="collapse navbar-collapse" id="navbar-mobile">						  
						<ul class="nav navbar-nav mr-auto float-left">							
							<li class="nav-item d-none d-lg-block d-none">
								
							<li class="dropdown nav-item mega-dropdown d-lg-block d-none" ><a class="dropdown-toggle nav-link" style="background: #24498C; color: #ffffff" href="#" data-toggle="dropdown">Routine Data Quality Assessments</a>
					
							</li>
						</ul>
						<ul class="nav navbar-nav float-left" data-menu="menu-navigation">
							<li class="nav-item dropdown"><a class="nav-link" style="color: #ffffff" href="<?= $baseUrl; ?>/site/apis">APIs</a></li>
							<li class="nav-item dropdown"><a class="nav-link" style="color: #ffffff" href="<?= $baseUrl; ?>/site/community">Community</a></li>
							<li class="nav-item dropdown"><a class="nav-link" style="color: #ffffff" href="<?= $baseUrl; ?>/site/about-us">About Us</a></li>
							<li class="nav-item dropdown"><a class="nav-link" style="color: #ffffff" href="<?= $baseUrl; ?>/site/login">Sign In</a></li>
						</ul>
						
					</div>
			</div>
			
		</div>
	</nav>
	<!-- END: Header-->
