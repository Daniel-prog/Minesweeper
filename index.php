<?php include_once 'engine/includes/header.php'; ?>

    <header>
        <div class="header1">
            <img src="assets/img/mineH.png" alt="Мина" width="50" height="50">
            <span class="name">Minesweeper Classic</span>
            <img src="assets/img/mineH.png" alt="Мина" width="50" height="50">
        </div>
    </header>

    <div class="container">

        <div id="pageHeader">
            <span class="Hello">Добро пожаловать,
                <?= isset($_SESSION['user']) ? $_SESSION['user']['nickname'] : 'Гость'; ?>!
            </span>

            <? if (!isset($_SESSION['user'])) { ?>
                <a href="registration.php" id="regbutton">Регистрация</a>
                <a href="auth.php" id="signinbtn">Вход</a>
            <? } else { ?>
                <a href="engine/logout.php" id="exitbtn">Выйти</a>
            <? } ?>
        </div>

        <div id="mainArticle">
            <div class="numberOfMines"></div>

            <div class="board-wrap">
                <a href="#!" class="minesweeper-btn" id="minesweeper-btn">Новая игра</a>

                <div class="board"></div>
            </div>

            <div class="endscreen" id="end"></div>

        </div>

        <div id="mainNav">
            <div class="sets">Настройки</div>
            <div class="col-left">
                <div class="settings">
                    <label for="boardSize">Размер поля:</label>
                    <input id="boardSize" type="range" value="10" min="4" max="20" step="2">
                    <span id="boardSizeValue">10x10</span>

                    <div class="field">
                        <label for="fieldset">Сложность:</label>
                        <fieldset>
                            <input type="radio" id="easy" name="difficulty" value="0.1" class="difficulty">
                            <label for="easy">Легко</label>
                            <input type="radio" id="normal" name="difficulty" value="0.2" class="difficulty" checked>
                            <label for="normal">Нормально</label>
                            <input type="radio" id="hard" name="difficulty" value="0.4" class="difficulty">
                            <label for="hard">Сложно</label>
                        </fieldset>
                    </div>

                </div>
            </div>
            <div class="sets">Личные рекорды</div>

            <? if (isset($_SESSION['user'])) { ?>
                <div class="records">
                    <div id="forField">Для поля 10х10</div>
                    <div id="forDiff">Сложность: Нормально</div>
                    <div id="one">
                        <img src="assets/img/1num.png" alt="1) " width="35" height="35">
                        <span>00:00:00.00</span>
                    </div>
                    <div id="two">
                        <img src="assets/img/2num.png" alt="2) " width="35" height="35">
                        <span>00:00:00.00</span>
                    </div>
                    <div id="three">
                        <img src="assets/img/3num.png" alt="3) " width="35" height="35">
                        <span>00:00:00.00</span>
                    </div>
                </div>
            <? } else { ?>
                <div id="forField">Авторизуйтесь для просмотра личных рекордов</div>
            <? } ?>
        </div>

        <div id="siteAds">
            <div id="stopwatch">Секундомер</div>
            <form name=MyForm>
                <input class="stopwatch" name=stopwatch size=10 value="00:00:00.00" disabled>
            </form>

            <a href="https://ru.wikipedia.org/wiki/Сапёр_(игра)" id="rules" target="_blank">Правила игры</a>
        </div>

        <div id="pageFooter">Связаться с автором: cliffboot8@gmail.com</div>

    </div>

<?php include_once 'engine/includes/footer.php'; ?>