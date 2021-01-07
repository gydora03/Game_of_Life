

function setup() {
	canvas.width = size;
	canvas.height = size;
	context.scale(scale, scale);
	context.fillStyle = "black";
	grid = createGameGrid();
}


function createGameGrid() {
	let arr = new Array(resolution);
	for (let i = 0; i < resolution; i++) {
		let rows = new Array(resolution);
		setCellsStatus(rows, 1);
		arr[i] = rows;
	}
	return arr;
}


function setCellsStatus(arr, status) {
	for (let i = 0; i < resolution; i++) {
		arr[i] = status;
	}
}


function initialState() {
	for (let j = 0; j < resolution; j++) {
		for (let i = 0; i < resolution; i++) {
			if (Math.random() < 0.5) {
				grid[i][j] = 0;
			}
		}
	}
}

function stating(state) {
	for (let j = 0; j < resolution; j++) {
		for (let i = 0; i < resolution; i++) {
			grid[i][j] = state[i][j];
		}
	}
}


function drawCells() {
	context.fillStyle = "white";
	context.fillRect(0, 0, resolution, resolution);
	context.fillStyle = "black";
	for (let j = 0; j < resolution; j++) {
		for (let i = 0; i < resolution; i++) {
			if (grid[i][j] == 0) {
				context.fillRect(i, j, 1, 1);
			}
		}
	}
}


function stepping() {
	let newGameGrid = createGameGrid();
	for (let j = 0; j < resolution; j++) {
		for (let i = 0; i < resolution; i++) {

		
			let neighbours = countNeighbors(i, j);
			
			if (grid[i][j] == 1 && neighbours === 3) {
				newGameGrid[i][j] = 0;
			} else if (grid[i][j] == 0 && (neighbours < 2 || neighbours > 3)) {
				newGameGrid[i][j] = 1;
			} else {
				newGameGrid[i][j] = grid[i][j];
			}
			
		}
	}
    grid = newGameGrid;
    
    writeGeneration();
	drawCells();
}


function writeGeneration() {
    numOfGeneration++;
    var genParagraph = document.getElementById("gen");
    genParagraph.innerHTML = numOfGeneration;
    document.getElementById("generation").appendChild(genParagraph);
}


function countNeighbors(x, y) {
	let sum = 0;
    for (let i = -1; i < 2; i++) {
        for (let j = -1; j < 2; j++) {
			
            if (i == 0 && j == 0) {
				continue;
			}
            if (x + i < 0 || x + i > resolution - 1) {
				continue;
			}
            if (y + j < 0 || y + j > resolution - 1) {
				continue;
			}
            if (grid[x + i][y + j] == 0) sum++;
        }
    }
    return sum;
}


function setTime() {
	interval = setInterval(stepping, 100);
}