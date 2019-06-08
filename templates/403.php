    <main>
        <nav class="nav">
          <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
            <li class="nav__item">
              <a href="all-lots.php?name=<?= $category['code'] ?>"><?= $category['name'] ?></a>
            </li>
            <?php endforeach ?>
          </ul>
        </nav>
        <section class="lot-item container">
            <h2>Ошибка 403 Доступ запрещен!</h2>
            <p>Для доступа к этой странице вам нужно <a href="log-in.php">войти на сайт</a> или <a href="sign-up.php">зарегистрироваться</a></p>
        </section>
    </main>