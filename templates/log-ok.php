    <main>
        <nav class="nav">
          <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
            <li class="nav__item">
              <a href="all-lots.php?code=<?= $category['code'] ?>"><?= $category['name'] ?></a>
            </li>
            <?php endforeach ?>
          </ul>
        </nav>
        <section class="lot-item container">
            <h2>Поздравляем! Вы успешно прошли регистрацию!</h2>
            <p>Для входа на сайт перейдите по <a href="log-in.php">ссылке</a></p>
        </section>
    </main>