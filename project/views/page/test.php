<div class="main__container">
  <aside>
    <div class="filter__menu">
      <form action="/form/" method="post"
      ">
      <div class="type__filter menu__block">
        <p>Тип прибора:</p>
        <?php
        foreach ($types as $type) {
          $string = '';
          if (isset($_SESSION['post']['type'])) {
            foreach ($_SESSION['post']['type'] as $elem) {
              if ($elem == $type['type']) {
                $string = " checked";
              }
            }
          }
          echo '<input type="checkbox" name="type[]" value="' . $type['type'] . '"' . $string . '> ' . $type['type'] . '<br>';
        }
        ?>
      </div>
      <div class="manufacturer__filter menu__block">
        <p>Производитель:</p>
        <?php
        foreach ($manufacturers as $manufacturer) {
          $string = '';
          if (isset($_SESSION['post']['manufacturer'])) {
            foreach ($_SESSION['post']['manufacturer'] as $elem) {
              if ($elem == $manufacturer['manufacturer']) {
                $string = " checked";
              }
            }
          }
          echo '<input type="checkbox" name="manufacturer[]" value="' . $manufacturer['manufacturer'] . '"' . $string . '> ' . $manufacturer['manufacturer'] . '<br>';
        }
        ?>
      </div>
      <div class="price__filter menu__block">
        <p>Цена прибора:</p>
        <input type="number" class="input__price" min="0" placeholder="От <?= $minPrice ?>"
               value="<?php if (isset($_SESSION['post']['minPrice'])) {
                 echo $_SESSION['post']['minPrice'];
               } ?>"
               name="minPrice">
        <input type="number" class="input__price" min="0" placeholder="До <?= $maxPrice ?>"
               value="<?php if (isset($_SESSION['post']['maxPrice'])) {
                 echo $_SESSION['post']['maxPrice'];
               } ?>"
               name="maxPrice">
      </div>
      <div class="submit__btn">
        <input type="submit" value="Применить" class="btn main__btn" name="enter_filter">
      </div>
      <div class="cancel__btn">
        <input type="submit" class="btn side__btn" value="Сбросить" name="cancel">
      </div>
      </form>
    </div>
  </aside>
  <main>
    <div class="products__container">
      <?php
      if (!empty($products)) {
        $isActiveWish = '';
        $isActiveCart = '';
        $wishText = 'В желаемое';
        $cartText = 'В корзину';
        foreach ($products as $product) {
          if (checkCookie ($product['product_name'], 'cartProduct')) {
            $isActiveCart = ' class="active__incart"';
            $cartText = 'Убрать';
          }
          if (checkCookie ($product['product_name'], 'wishProduct')) {
            $isActiveWish = ' class="active__inwish"';
            $wishText = 'Отменить';
          }
          echo '<div class="product">
  <div class="product__inner">
    <div class="icon__container">
      <a href="/product/' . $product['id'] . '"><img src="/project/webroot/img/' . strtolower ($product['manufacturer']) . '/icon_' . $product['img'] . '.jpg" alt="Фото прибора" class="icon"></a>
    </div>
    <div class="product__info">
      <h3><a href="/product/' . $product['id'] . '">' . $product['product_name'] . '</a></h3>
      <p>Тип прибора: ' . $product['type'] . '</p>
      <p>Производитель: ' . $product['manufacturer'] . '</p>
    </div>
    <div class="price">
      <p>' . $product['price'] . ' Р</p>
    </div>
  </div>
  <div class="product__btn">
    <button class="btn side__btn inwish__btn" data-btntype="wish" data-productname="' . $product['product_name'] . '"><span' . $isActiveWish . '>' . $wishText . '</span.></button>
    <button class="btn main__btn incart__btn" data-btntype="cart" data-productname="' . $product['product_name'] . '"><span' . $isActiveCart . '>' . $cartText . '</span></button>
  </div>
</div>';
          $isActiveWish = '';
          $isActiveCart = '';
          $wishText = 'В желаемое';
          $cartText = 'В корзину';
        }
        if (!empty($_SESSION['post'])) {
          $formHref = '/form';
        } else $formHref = '';
        echo '<div class="pages__container">
<a href="' . $formHref . '/" class="pages first_page"' . isDisabled ($curPage, 1) . ' title="На первую страницу"></a>
<a href="' . $formHref . '/page/' . ($curPage - 1) . '" class="pages prev_page"' . isDisabled ($curPage, 1) . ' title="На предыдущую страницу"></a>';
        $show = isHidden ($curPage, $showPages, $totalProducts);
        for ($i = 1; $i <= $totalProducts; $i++) {
          if ($i == 1) {
            $href = '/';
          } else {
            $href = "/page/$i";
          }
          $class = 'pages';
          if ($i == $curPage) {
            $class .= ' active';
          }
          if (in_array ($i, $show)) {
            $hidden = '';
          } else $hidden = 'hidden';
          echo '<a href="' . $formHref . $href . '" class="' . $class . '"' . $hidden . '>' . $i . '</a>';
        }
        echo '<a href="' . $formHref . '/page/' . ($curPage + 1) . '" class="pages next_page"' . isDisabled ($curPage, $totalProducts) . ' title="На следующую страницу"></a>
<a href="' . $formHref . '/page/' . $totalProducts . '" class="pages last_page"' . isDisabled ($curPage, $totalProducts) . ' title="На последнюю страницу"></a>
</div>';
      } else echo '<div class="not__found">
<p>По вашему запросу ничего не найдено</p>
<a href="/" class="empty__response">На главную</a>
</div>';


      function isDisabled ($curPage, $value)
      {
        if ($curPage == $value) {
          return ' hidden';
        } else return '';
      }

      function isHidden ($curPage, $showPages, $totalProducts)
      {
        $result = [$curPage];
        $supIndex = $showPages;
        if ($curPage - $showPages < 1) {
          while ($curPage - $showPages < 1) {
            ++$supIndex;
            --$showPages;
          }
        } else if ($curPage + $supIndex > $totalProducts) {
          while ($curPage + $supIndex > $totalProducts) {
            --$supIndex;
            ++$showPages;
          }
        }
        for ($i = $supIndex + $curPage; $i != $curPage; $i--) {
          $result[] = $i;
        }
        for ($i = $curPage - $showPages; $i != $curPage; $i++) {
          $result[] = $i;
        }
        return $result;
      }

      function checkCookie ($name, $cookieName)
      {
        if (isset($_COOKIE[$cookieName])) {
          $arrCookies = explode (', ', $_COOKIE[$cookieName]);
          if (in_array ($name, $arrCookies)) {
            return true;
          }
        }
        return false;
      }

      ?>
    </div>
  </main>
</div>