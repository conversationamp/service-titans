<div class="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">

            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="<?php echo e(asset(auth()->user()->name->image ?? '')); ?>" alt="profile-user" class="rounded-circle" 
                     onerror="this.src='<?php echo e(asset('assets/images/sabi.jpg')); ?>'"
                    />
                    <span class="ml-1 nav-user-name"><?php echo e(auth()->user()->name); ?> <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="<?php echo e(route('profile')); ?>"><i
                            class="dripicons-user text-muted mr-2"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="dripicons-exit text-muted mr-2"></i> Logout</a>
                </div>
            </li>

        </ul>
        <!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <a href="<?php echo e(route('dashboard')); ?>">
                    <span class="responsive-logo">
                        <?php if(auth()->user()->role == 0): ?>
                            <img src="<?php echo e(showLogo()); ?>" alt="logo-small" class="logo-sm align-self-center"
                                height="34">
                        <?php endif; ?>
                    </span>
                </a>
            </li>
            <li>
                <button class="button-menu-mobile nav-link">
                    <i data-feather="menu" class="align-self-center"></i>
                </button>
            </li>

        </ul>
    </nav>
    <!-- end navbar-->
</div>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/components/header.blade.php ENDPATH**/ ?>