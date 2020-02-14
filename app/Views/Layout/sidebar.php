<?php if(isset($_SESSION['kauz_lager'])): ?>
<aside class="side-nav bg-grey">
    <div class="container-sm">
        <p class="text-center">Welcome: <?php echo $_SESSION['kauz_lager']['email']; ?></p>
        <ul class="row">
            <li><a href="">Settings</a></li>
            <li><a href="">Edit profile</a></li>
        </ul>
    </div>

    <p>Dashboard</p>

    <!-- <div class="sidebar-item"> -->
        <h4><a href="<?php echo Helper::URL('Dashboard', 'Index'); ?>">Übersicht</a></h4>
    <!-- </div> -->

    <div class="sidebar-item">
        <h4>Bücher</h4>
        <a href="<?php echo Helper::URL('Book', 'Create') ?>">Buch hinzufügen</a>
        <a href="<?php echo Helper::URL('Dashboard', 'Books'); ?>">Bücher</a>
    </div>

    <div class="sidebar-item">
        <h4>Regale</h4>
        <a href="<?php echo Helper::URL('Dashboard', 'Regale'); ?>">Regale</a>
        <a href="<?php echo Helper::URL('Shelf', 'Create'); ?>">Regal hinzufügen</a>
    </div>

    <div class="sidebar-item">
        <h4>Kategorien</h4>
        <a href="<?php echo Helper::URL('Category', 'Create'); ?>">Kategorie erstellen</a>
        <a href="<?php echo Helper::URL('Dashboard', 'Categories'); ?>">Kategorien</a>
    </div>

    <div class="sidebar-item">
        <h4>Benutzer</h4>
        <a href="<?php echo Helper::URL('User', 'Create'); ?>">Benutzer erstellen</a>
        <a href="<?php echo Helper::URL('Dashboard', 'Users'); ?>">Alle Benutzer</a>
    </div>
</aside>
<?php endif; ?>