<nav class="navbar navbar-expand navbar-light navbar-bg">
	<!--Icone do menu-->
	<a class="ms-5 sidebar-toggle js-sidebar-toggle">
		<i class="hamburger align-self-center"></i>
	</a>
	<div class="navbar-collapse collapse">
		<ul class="navbar-nav navbar-align">
			<li class="nav-item dropdown">
				<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
					<i class="align-middle" data-feather="settings"></i>
				</a>
				<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
					<img src="../upload/<?php echo $_SESSION['foto']?>" class="avatar img-responsive rounded" alt="FotoUsuario" />
					<label class="text-dark"><?php echo $_SESSION['nome']?></label>
				</a>
			</li>
		</ul>
	</div>
</nav>