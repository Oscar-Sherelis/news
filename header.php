    <header>
        <h3><a href="/news_task">Logo</a></h3>
        <nav>
            <?php if (isset($_SESSION['loged_in'])) : ?>
                <div>
                    <?php if ($_SESSION['loged_in'] === 'admin') : ?>
                        <a href="/news_task/admin/admin.php">
                            <?php print $_SESSION['loged_in']; ?> Loged in
                            <a href="/news_task/admin/edit_types.php">Edit types</a>
                            <a href="/news_task/admin/new_article.php">New article</a>
                        </a>
                    <?php else : ?>
                        <a href="/news_task/">
                            <?php print $_SESSION['loged_in']; ?> Loged in
                        </a>
                        <a href="/logout.php">Logout</a>
                    <?php endif ?>
                </div>
            <?php else : ?>
                <a href="/news_task/login.php">Login</a>
                <a href="/news_task/register.php">Register</a>
            <?php endif; ?>
        </nav>
    </header>