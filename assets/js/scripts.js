'use strict';

console.clear();

readRecords();

let easy = document.getElementById("easy");
let normal = document.getElementById("normal");
let hard = document.getElementById("hard");

let size = 10;
let bombFrequency = 0.2;
let tileSize = 50;

let amount, tiles, boardSize;
let siteAds = document.getElementById('siteAds');
const board = document.querySelectorAll('.board')[0];

const restartBtn = document.querySelectorAll('.minesweeper-btn')[0];
const endscreen = document.querySelectorAll('.endscreen')[0];

// Настройки
const boardSizeBtn = document.getElementById('boardSize');
const difficultyBtns = document.querySelectorAll('.difficulty');

let difficulty = 1, count = 0, bombs = [], numbers = [], gameOver = false;
let numberColors = ['#3498db', '#2ecc71', '#e74c3c', '#9b59b6', '#f1c40f', '#1abc9c', '#34495e', '#7f8c8d',];
let endscreenContent = {
    win: '<span id="closebtn">[Х]</span><img src="assets/img/you-win-png-4.png" ' +
        'width="300" height="150" title="(Для начала новой игры нажмите кнопку сверху)">',
    loose: '<span id="closebtn">[Х]</span><img src="assets/img/GameOver.png" ' +
        'width="300" height="150" title="(Для начала новой игры нажмите кнопку сверху)">'
};

const clear = () => {
    count = 0;
    gameOver = false;
    bombs = [];
    numbers = [];
    endscreen.innerHTML = '';
    endscreen.classList.remove('show');
    tiles.forEach(tile => {
        tile.remove();
    });

    setup();
};

const setup = () => {
    amount = 0;
    const numOfTiles = Math.pow(size, 2);

    for (let i = 0; i < numOfTiles; i++) {
        const tile = document.createElement('div');
        tile.classList.add('tile');
        board.appendChild(tile);
    }
    tiles = document.querySelectorAll('.tile');
    boardSize = Math.sqrt(tiles.length);
    board.style.width = boardSize * tileSize + 'px'; //board width

    document.documentElement.style.setProperty('--tileSize', `${tileSize}px`);
    document.documentElement.style.setProperty('--boardSize', `${boardSize * tileSize}px`);

    let x, y;

    while (amount === 0) {
        x = 0;
        y = 0;
        mines();
    }

    function mines() {
        tiles.forEach((tile) => {

            tile.setAttribute('data-tile', `${x},${y}`);

            let random_boolean = Math.random() < bombFrequency;
            if (random_boolean) {
                amount++;
                bombs.push(`${x},${y}`);
                if (x > 0) numbers.push(`${x - 1},${y}`);
                if (x < boardSize - 1) numbers.push(`${x + 1},${y}`);
                if (y > 0) numbers.push(`${x},${y - 1}`);
                if (y < boardSize - 1) numbers.push(`${x},${y + 1}`);

                if (x > 0 && y > 0) numbers.push(`${x - 1},${y - 1}`);
                if (x < boardSize - 1 && y < boardSize - 1) numbers.push(`${x + 1},${y + 1}`);

                if (y > 0 && x < boardSize - 1) numbers.push(`${x + 1},${y - 1}`);
                if (x > 0 && y < boardSize - 1) numbers.push(`${x - 1},${y + 1}`);
            }

            x++;
            if (x >= boardSize) {
                x = 0;
                y++;
            }

            tile.oncontextmenu = function (e) {
                e.preventDefault();
                flag(tile);
            };

            tile.addEventListener('click', handleClick);

            tile.addEventListener('click', function () {
                clickTile(tile);
            });
        });
    }

    document.querySelector('.numberOfMines').innerHTML = "💣" + amount;

    numbers.forEach(num => {
        let coords = num.split(',');
        let tile = document.querySelectorAll(`[data-tile="${parseInt(coords[0])},${parseInt(coords[1])}"]`)[0];
        let dataNum = parseInt(tile.getAttribute('data-num'));
        if (!dataNum) dataNum = 0;
        tile.setAttribute('data-num', dataNum + 1);
    });
};

const flag = (tile) => {
    if (gameOver) return;
    if (!tile.classList.contains('tile--checked')) {
        if (!tile.classList.contains('tile--flagged')) {
            amount--;
            document.querySelector('.numberOfMines').innerHTML = "💣" + amount;
            tile.innerHTML = '🚩';
            tile.classList.add('tile--flagged');
        } else {
            amount++;
            document.querySelector('.numberOfMines').innerHTML = "💣" + amount;
            tile.innerHTML = '';
            tile.classList.remove('tile--flagged');
        }
    }
};

const clickTile = (tile) => {
    ++count;
    if (count === 1) {
        tiles.forEach((tile) => {
            tile.removeEventListener('click', handleClick);
        });
    }

    if (gameOver) return;
    if (tile.classList.contains('tile--checked') || tile.classList.contains('tile--flagged')) return;
    let coordinate = tile.getAttribute('data-tile');
    if (bombs.includes(coordinate)) {
        endGame(tile);
    } else {

        let num = tile.getAttribute('data-num');
        if (num != null) {
            tile.classList.add('tile--checked');
            tile.innerHTML = num;
            tile.style.color = numberColors[num - 1];
            setTimeout(() => {
                checkVictory();
            }, 100);
            return;
        }

        checkTile(tile, coordinate);
    }
    tile.classList.add('tile--checked');
};


const checkTile = (tile, coordinate) => {

    console.log('✔');
    let coords = coordinate.split(',');
    let x = parseInt(coords[0]);
    let y = parseInt(coords[1]);

    setTimeout(() => {
        if (x > 0) {
            let targetW = document.querySelectorAll(`[data-tile="${x - 1},${y}"`)[0];
            clickTile(targetW, `${x - 1},${y}`);
        }
        if (x < boardSize - 1) {
            let targetE = document.querySelectorAll(`[data-tile="${x + 1},${y}"`)[0];
            clickTile(targetE, `${x + 1},${y}`);
        }
        if (y > 0) {
            let targetN = document.querySelectorAll(`[data-tile="${x},${y - 1}"]`)[0];
            clickTile(targetN, `${x},${y - 1}`);
        }
        if (y < boardSize - 1) {
            let targetS = document.querySelectorAll(`[data-tile="${x},${y + 1}"]`)[0];
            clickTile(targetS, `${x},${y + 1}`);
        }

        if (x > 0 && y > 0) {
            let targetNW = document.querySelectorAll(`[data-tile="${x - 1},${y - 1}"`)[0];
            clickTile(targetNW, `${x - 1},${y - 1}`);
        }
        if (x < boardSize - 1 && y < boardSize - 1) {
            let targetSE = document.querySelectorAll(`[data-tile="${x + 1},${y + 1}"`)[0];
            clickTile(targetSE, `${x + 1},${y + 1}`);
        }

        if (y > 0 && x < boardSize - 1) {
            let targetNE = document.querySelectorAll(`[data-tile="${x + 1},${y - 1}"]`)[0];
            clickTile(targetNE, `${x + 1},${y - 1}`);
        }
        if (x > 0 && y < boardSize - 1) {
            let targetSW = document.querySelectorAll(`[data-tile="${x - 1},${y + 1}"`)[0];
            clickTile(targetSW, `${x - 1},${y + 1}`);
        }
    }, 10);
};


/* Game over */
const endGame = (tile) => {
    Stop();
    tile.style.background = 'red';
    console.log('💣 Booom! Game over.');
    endscreen.innerHTML = endscreenContent.loose;
    document.getElementById('closebtn').onclick = function () {
        document.getElementById('end').style.display = "none";
    };
    endscreen.classList.add('show');
    gameOver = true;
    tiles.forEach(tile => {
        let coordinate = tile.getAttribute('data-tile');
        if (bombs.includes(coordinate)) {
            tile.classList.remove('tile--flagged');
            tile.classList.add('tile--checked', 'tile--bomb');
            tile.innerHTML = '💣';
        }
    });
};

const checkVictory = () => {
    if (gameOver) return;
    let win = true;
    tiles.forEach(tile => {
        let coordinate = tile.getAttribute('data-tile');
        if (!tile.classList.contains('tile--checked') && !bombs.includes(coordinate)) win = false;
    });
    if (win) {
        siteAds.insertAdjacentHTML('beforeend', '<div class="yourTime">' +
            'Поздравляем! Ваше время: ' + readout + '</div>');
        Send();
        Stop();
        endscreen.innerHTML = endscreenContent.win;
        document.getElementById('closebtn').onclick = function () {
            document.getElementById('end').style.display = "none";
        };
        endscreen.classList.add('show');
        gameOver = true;
    }
};


/* Start */
setup();

/* New game */
restartBtn.addEventListener('click', function (e) {
    ClearClock();
    document.getElementById('end').style = null;
    if (document.querySelector('.yourTime'))
        document.querySelector('.yourTime').remove();
    e.preventDefault();
    clear();
});

// Settings
boardSizeBtn.addEventListener('change', function () {
    console.log(this.value);
    size = this.value;
    tileSize = 70 - (size * 2);
    ClearClock();
    document.getElementById('end').style = null;
    if (document.querySelector('.yourTime'))
        document.querySelector('.yourTime').remove();
    clear();

    document.getElementById("boardSizeValue").innerHTML = size + "x" + size;
    $.ajax({
        url: 'engine/getSessionData.php',
        type: 'POST',
        dataType: 'json',

        success(data) {
            if (data['user']) {
                document.getElementById("forField").innerHTML = "Для поля " + size + "x" + size;
            }
        }
    });

    readRecords();
});

difficultyBtns.forEach(btn => {
    btn.addEventListener('click', function () {

        if (easy.checked) {
            difficulty = 0;
            document.getElementById("forDiff").innerHTML = "Сложность: Легко";
        }
        if (normal.checked) {
            difficulty = 1;
            document.getElementById("forDiff").innerHTML = "Сложность: Нормально";
        }
        if (hard.checked) {
            difficulty = 2;
            document.getElementById("forDiff").innerHTML = "Сложность: Сложно";
        }

        readRecords();

        console.log(this.value);
        bombFrequency = this.value;
        ClearClock();
        document.getElementById('end').style = null;
        if (document.querySelector('.yourTime'))
            document.querySelector('.yourTime').remove();
        clear();
    });
});

function handleClick() {
    Start();
}

function Send() {
    score = Math.round(score / 10);

    $.ajax({
        url: 'engine/sendResults.php',
        type: 'POST',
        dataType: 'json',
        data: {
            size: size,
            diff: difficulty,
            read: readout,
            score: score
        },

        success(data) {
            $(`#one span`).html(data[size][difficulty][0][0]);
            $(`#two span`).html(data[size][difficulty][1][0]);
            $(`#three span`).html(data[size][difficulty][2][0]);
        }
    });
}

function readRecords() {
    $.ajax({
        url: 'engine/getRecords.php',
        type: 'POST',
        dataType: 'json',

        success(data) {
            $(`#one span`).html(data[size][difficulty][0][0]);
            $(`#two span`).html(data[size][difficulty][1][0]);
            $(`#three span`).html(data[size][difficulty][2][0]);
        }
    });
}