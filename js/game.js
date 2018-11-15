const debug = true;

let gameInstance = null;

function init() {
    gameInstance = new Game();

    gameInstance.initGame();
}

function gameLoop() {
    gameInstance.onLoop();
}

document.addEventListener("DOMContentLoaded", init);

class Game {
    constructor() {
        this.level = null;
        this.frames = 0;
        this.lastFrame = 0;
        this.lastSecond = 0;
        this.totalDelay = 0;
        this.lastDelta = 0;
        this.kHandler = new KeyHandler();
        this.display = null;
        this.score = 0;
        this.running = true;
    }

    initGame() {
        this.display = document.getElementById("gameDisplay");
        this.display

        if (this.display == null) {
            window.location.replace("./error.html");
        } else {
            this.lastFrame = Date.now();
            this.lastSecond = this.lastFrame;

            this.loadLevel(900, 600);

            window.setInterval(gameLoop, 1);
        }
    }

    onLoop() {
        if (!this.running)
        {
            return;
        }

        let now = Date.now();
        this.lastDelta = now - this.lastFrame;
        this.lastFrame = now;
        this.totalDelay += this.lastDelta;


        this.update();
        this.frames++;

        if (now - this.lastSecond >= 1000) {
            this.lastSecond = now;

            if (debug) {
                console.log("FPS: " + this.frames + "   Average Delta: " + this.totalDelay / this.frames);
            }

            this.frames = 0;
            this.totalDelay = 0;
        }

    }

    loadLevel(width, height) {
        this.level = new Level(width, height);

        var scorePara = document.getElementById("score");

        this.level.paddingTop = scorePara.offsetTop + scorePara.clientHeight + 20;
        this.level.paddingLeft = (gameInstance.display.clientWidth / 2) - (this.level.width / 2);

        var background = document.getElementById("background");

        background.src = "./images/background.png";
        background.style.left = this.level.paddingLeft + "px";
        background.style.top = this.level.paddingTop + "px";
        background.style.width = this.level.width + "px";
        background.style.height = this.level.height + "px";

        for (var i = 0; i < 10; i++) {
            this.level.addFish();
        }

        this.level.addFish(true);
    }

    update() {
        this.kHandler.downKeys.forEach(callback => {
            callback();
        });

        this.level.entities.forEach(entity => {

            if (entity.doFishAi != undefined) {
                entity.doFishAi();
            }
        });
    }

    setScore(scr) {
        var elem = document.getElementById("score");

        elem.innerText = "Score: " + scr;
    }
}

class Level {
    constructor(width, height) {
        this.entities = new Map();
        this.width = width;
        this.height = height;
        this.paddingTop = 0;
        this.paddingLeft = 0;
    }

    getSpriteOverlappingSprite(sprite) {
        var values = this.entities.values();

        while (true)
        {
            var val = values.next();

            if (val.done)
            {
                break;
            }

            var other = val.value.sprite;

            if (other.name !== sprite.name)
            {
                if (sprite.getX() < other.getX() + other.getWidth() && sprite.getX() + sprite.getWidth() > other.getX() && sprite.getY() < other.getY() + other.getHeight() && sprite.getY() + sprite.getHeight() > other.getY())
                {
                    return other;
                }
            }
        }
    }

    removeSprite(name) {
        if (name == "player") {
            gameInstance.running = false;
            document.cookie = "score=" + gameInstance.score;
            window.location.assign("./gameover.php");
        } else {
            if (this.entities.has(name)) {
                if (this.entities.get(name).sprite != undefined) {
                    this.entities.get(name).sprite.remove();
                }

                this.entities.delete(name);

                this.addFish();
            }
        }
    }

    addFish(isPlayer) {
        let startX = parseInt(Math.random() * (this.width - 100)) + this.paddingLeft;
        let startY = parseInt(Math.random() * (this.height - 100)) + this.paddingTop;
        
        if (isPlayer == true)
        {
            var sprite = new Sprite("player", "fishman.png", this, gameInstance.display);
            sprite.setHeight(12);
            sprite.setWidth(24);
            sprite.setX(startX);
            sprite.setY(startY);
            var player = new Player(sprite);
            this.entities.set("player", player);
        } else 
        {
            let startWidth = parseInt(Math.random() * 64) + 5;
            let startHeight = parseInt(Math.random() * 32) + 5;
    
            let spr = new Sprite("fish" + Math.ceil(Math.random() * 1000000), "fishman.png", this, gameInstance.display);
    
            spr.setX(startX);
            spr.setY(startY);
            spr.setWidth(startWidth);
            spr.setHeight(startHeight);
    
            let fsh = new Fish(spr);
            this.entities.set(spr.name, fsh);
        }
    }
}

class Sprite {
    constructor(name, path, level, display) {
        this.x = 5;
        this.y = 5;
        this.width = 64;
        this.height = 64;
        this.speed = Math.random() / 5;


        this.path = path;
        this.name = name;
        this.level = level;
        this.display = display;
        this.rotation = 0;
        this.flipX = -1;
        this.solid = true;

        this.onLeftHit = null;
        this.onRightHit = null;
        this.onTopHit = null;
        this.onBottomHit = null;

        this.img = document.createElement("img");
        this.img.id = this.name;
        this.img.src = "./images/" + this.path;
        this.img.left = this.x;
        this.img.top = this.y;
        this.display.appendChild(this.img);

        this.setX(this.x);
        this.setY(this.y);
        this.setWidth(this.width);
        this.setHeight(this.height);
    }

    move(direction, movement) {
        if (movement == null) {
            movement = this.speed;
        }

        if (direction == "left") {
            var moveToX = this.getX() - (movement * gameInstance.lastDelta);

            if (moveToX < this.level.paddingLeft) {
                if (gameInstance.level.entities.get(this.name).changeSwimDirection != undefined) {
                    gameInstance.level.entities.get(this.name).changeSwimDirection();
                }

                moveToX = this.level.paddingLeft;
            }

            this.setX(moveToX);

            if (this.flipX == 1) {
                this.flipHorizontal();
            }
        } else if (direction == "right") {
            var moveToX = this.getX() + (movement * gameInstance.lastDelta);

            if (moveToX + this.getWidth() > this.level.width + this.level.paddingLeft) {
                if (gameInstance.level.entities.get(this.name).changeSwimDirection != undefined) {
                    gameInstance.level.entities.get(this.name).changeSwimDirection();
                }

                moveToX = this.level.width - this.getWidth() + this.level.paddingLeft;
            }

            this.setX(moveToX);
            if (this.flipX == -1) {
                this.flipHorizontal();
            }
        } else if (direction == "up") {
            var moveToY = this.getY() - (movement * gameInstance.lastDelta);

            if (moveToY < this.level.paddingTop) {
                if (gameInstance.level.entities.get(this.name).changeSwimDirection != undefined) {
                    gameInstance.level.entities.get(this.name).changeSwimDirection();
                }

                moveToY = this.level.paddingTop;
            }

            this.setY(moveToY);
        } else if (direction == "down") {
            var moveToY = this.getY() + (movement * gameInstance.lastDelta);

            if (moveToY + this.getHeight() > this.level.height + this.level.paddingTop) {
                if (gameInstance.level.entities.get(this.name).changeSwimDirection != undefined) {
                    gameInstance.level.entities.get(this.name).changeSwimDirection();
                }

                moveToY = this.level.height - this.getHeight() + this.level.paddingTop;
            }


            this.setY(moveToY);
        }

        this.doCollision();
    }

    doCollision() {
        var other = gameInstance.level.getSpriteOverlappingSprite(this);

        if (other == null) return;

        if (other == gameInstance.level.entities.get("player").sprite && gameInstance.level.entities.get("player").safe == true)
        {
            return;
        }

        if (other.getSize != undefined) {
            if (this.getSize() > other.getSize()) {
                var grow = Math.ceil(other.getSize() / 500);

                if (this.name == "player") {
                    gameInstance.score += grow;
                    gameInstance.setScore(gameInstance.score);
                }

                gameInstance.level.removeSprite(other.name);
                this.setWidth(this.getWidth() + grow);
                this.setHeight(this.getHeight() + grow);
            } else if (this.getSize() < other.getSize()) {
                var grow = Math.ceil(this.getSize() / 500);

                if (other.name == "player") {
                    gameInstance.score += grow;
                    gameInstance.setScore(gameInstance.score);
                }

                gameInstance.level.removeSprite(this.name);
                other.setWidth(other.getWidth() + grow);
                other.setHeight(other.getHeight() + grow);
            }
        }
    }

    setX(x) {
        this.x = x;
        this.img.style.left = this.x + "px";
    }

    getX() {
        return this.x;
    }

    setY(y) {
        this.y = y;
        this.img.style.top = this.y + "px";
    }

    getY() {
        return this.y;
    }

    setWidth(w) {
        this.width = w;
        this.img.style.width = this.width + "px";
    }

    getWidth() {
        return this.width;
    }

    setHeight(h) {
        this.height = h;
        this.img.style.height = this.height + "px";
    }

    getHeight() {
        return this.height;
    }

    setSpeed(speed) {
        this.speed = speed;
    }

    flipHorizontal() {
        if (this.flipX == -1) {
            this.flipX = 1;
        } else {
            this.flipX = -1;
        }

        this.img.style.transform = "scaleX(" + this.flipX + ")";
    }

    getSize() {
        return this.getWidth() * this.getHeight();
    }

    remove() {
        var elem = document.getElementById(this.name);
        gameInstance.display.removeChild(elem);
    }
}

class Player {
    constructor(sprite) {
        this.sprite = sprite;
        this.sprite.speed = 0.2;
        this.safe = true;

        gameInstance.kHandler.keyDownCallbacks.set("w", function () {
            gameInstance.level.entities.get("player").safe = false;
            gameInstance.level.entities.get("player").sprite.move("up");
        });

        gameInstance.kHandler.keyDownCallbacks.set("s", function () {
            gameInstance.level.entities.get("player").safe = false;
            gameInstance.level.entities.get("player").sprite.move("down");
        });

        gameInstance.kHandler.keyDownCallbacks.set("a", function () {
            gameInstance.level.entities.get("player").safe = false;
            gameInstance.level.entities.get("player").sprite.move("left");
        });

        gameInstance.kHandler.keyDownCallbacks.set("d", function () {
            gameInstance.level.entities.get("player").safe = false;
            gameInstance.level.entities.get("player").sprite.move("right");
        });
    }
}

class Fish {
    constructor(sprite) {
        this.sprite = sprite;
        this.lastSwimDirectionChange = Date.now();
        this.swingChangeDelay = Math.ceil(Math.random() * 3000);
        this.movementVertical = "none";
        this.movementHorizontal = "none";
        this.changeSwimDirection();
    }

    doFishAi() {
        if (Date.now() - this.lastSwimDirectionChange >= (300 + this.swingChangeDelay)) {
            this.lastSwimDirectionChange = Date.now();
            this.changeSwimDirection();
        }

        if (this.movementHorizontal != "none") {
            this.sprite.move(this.movementHorizontal);
        }

        if (this.movementVertical != "none") {
            this.sprite.move(this.movementVertical);
        }
    }

    changeSwimDirection() {
        let randDir = Math.ceil(Math.random() * 3);

        switch (randDir) {
            case 1:
                this.movementHorizontal = "left";
                break;
            case 2:
                this.movementHorizontal = "right";
                break;
            default:
                this.movementHorizontal = "none";
        }

        randDir = Math.ceil(Math.random() * 3);

        switch (randDir) {
            case 1:
                this.movementVertical = "up";
                break;
            case 2:
                this.movementVertical = "down";
                break;
            default:
                this.movementVertical = "none";
        }
    }
}

class KeyHandler {
    constructor() {
        this.downKeys = new Map();
        this.keyDownCallbacks = new Map();
        this.keyPressedCallbacks = new Map();
        window.addEventListener("keydown", function (arg) {
            if (gameInstance.kHandler.keyDownCallbacks.has(arg.key)) {
                gameInstance.kHandler.downKeys.set(arg.key, gameInstance.kHandler.keyDownCallbacks.get(arg.key));
            }
        });

        window.addEventListener("keyup", function (arg) {
            gameInstance.kHandler.downKeys.delete(arg.key);

            if (gameInstance.kHandler.keyPressedCallbacks.get(arg.key) != null) {
                gameInstance.kHandler.keyPressedCallbacks.get(arg.key)();
            }
        });
    }

}