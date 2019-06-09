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
    <div class="container">
      <section class="lots">
        <h2><?= empty($search_lots) ? 'Ничего не найдено по вашему запросу ' : 'Результаты поиска по запросу ' ?>«<span><?= $search ?></span>»</h2>
        <ul class="lots__list">
    <?php foreach ($search_lots as $search_lot): ?> 
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= $search_lot['image'] ?>" width="350" height="260" alt="<?= $search_lot['title'] ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= $search_lot['name'] ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $search_lot['lot_id'] ?>"><?= $search_lot['title'] ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= price_format($search_lot['price_start']) ?></b></span>
                </div>
                <div class="lot__timer timer <?= add_lot_status_class($search_lot['lot_end']) ?>">
                  <?= get_formatted_lot_end($search_lot['lot_end']) ?>
                </div>
              </div>
            </div>
          </li>
           <?php endforeach ?> 
          </ul>
     </section>
    <?php if ((int)$pages_count > 1): ?>
        <ul class="pagination-list">
        <?php if ((int)$cur_page  > 1): ?>
        <li class="pagination-item pagination-item-prev"><a href="search.php?<?= $search ? 'search=' . $search . '&' : '' ?>page=<?= ((int)$cur_page - 1) ?>">Назад</a></li>
        <?php endif ?>      
        <?php foreach ($pages as $page): ?>
        <li class="pagination-item <?= ($page === $cur_page) ? 'pagination-item-active' : '' ?>">
            <a href="search.php?<?= $search ? 'search=' . $search . '&' : '' ?>page=<?= $page ?>"><?= $page ?></a></li>
        <?php endforeach; ?>
        <?php if ((int)$cur_page  < (int)$pages_count): ?>
        <li class="pagination-item pagination-item-next"><a href="search.php?<?= $search ? 'search=' . $search . '&' : '' ?>page=<?= ((int)$cur_page + 1) ?>">Вперед</a></li>
        <?php endif ?>
    </ul>
<?php endif ?>
    </div>
  </main>