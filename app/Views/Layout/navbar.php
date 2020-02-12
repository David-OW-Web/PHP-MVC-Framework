<nav class="navigation bg-dark">
<ul class="navbar">
    <li><?php echo SITENAME; ?></li>
    <?php foreach(["Home", "Login", "Contact", "About"] as $k => $v): ?>
    <li class="nav-item"><a href="<?php echo $v; ?>" class="text-white"><?php echo $v; ?></a></li>
    <?php endforeach; ?>
</ul>
</nav>