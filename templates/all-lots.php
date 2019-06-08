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
    <div class="container">
      <section class="lots">
        <h2>Все лоты в категории <span>«<?= $cat_lots[0]['name'] ?>»</span></h2>

  <ul class="lots__list">
    <?php foreach ($cat_lots as $cat_lot): ?> 
          <li class="lots__item lot <?= (strtotime($cat_lot['lot_end']) < time()) ? 'visually-hidden' : '' ?>">
            <div class="lot__image">
              <img src="<?= $cat_lot['image'] ?>" width="350" height="260" alt="<?= $cat_lot['title'] ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= $cat_lot['name'] ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $cat_lot['lot_id'] ?>"><?= $cat_lot['title'] ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= price_format($cat_lot['price_start']) ?></b></span>
                </div>
                <div class="lot__timer timer <?= add_lot_status_class($cat_lot['lot_end']) ?>">
                  <?= get_formatted_lot_end($cat_lot['lot_end']) ?>
                </div>
              </div>
            </div>
          </li>
           <?php endforeach ?> 
  </ul>
   
</section>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
    </div>
  </main>