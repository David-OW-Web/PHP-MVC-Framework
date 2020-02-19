<nav class="navigation bg-dark">
<ul class="navbar">
    <li class="text-white"><?php echo SITENAME; ?></li>
    <?php foreach(["Home", "Login", "Contact", "About"] as $k => $v): ?>
    <li class="nav-item"><a href="<?php echo $v; ?>" class="text-white"><?php echo $v; ?></a></li>
    <?php endforeach; ?>
    <?php if(isset($_SESSION['session'])): ?>
    <li class="text-white"><?php echo $_SESSION['session']['username']; ?></li>
        <li><a href="<?php echo Helper::URL('User', 'Logout'); ?>" class="text-white">Logout</a></li>
    <?php else: ?>
    <li><a href="<?php echo Helper::URL('User', 'Login'); ?>" class="text-white">Login</a></li>
    <?php endif; ?>
</ul>
</nav>
