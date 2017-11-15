/*
Jiaqi Zhang; AJ; HW8
This is the js file for the game Fifteen Puzzle. When shuffle is clicked,
the 15 tiles are randomly rearranged. The puzzle piece next to any blank 
tile should turn red when the cursor hovers on it. Also when the piece is 
clicked, it's able to move to the blank piece's position.
*/
"use strict";
(function () {
	var blankCol = 3; //the column of the blank tile.
	var blankRow = 3; //the row number of the blank tile.

	window.onload = function() {
		creatPuzzle();
		var puzzles = document.querySelectorAll(".puzzles");
		for (var i = 0; i < puzzles.length; i++) {
			puzzles[i].onmouseover = colorIt;	
			puzzles[i].onclick = moveIt;
		}
		document.getElementById("shufflebutton").onclick = shuffle;
	};

	//to create 15 tiles at the beginning of the game. Each tiel has
	//a number to label itself.
	function creatPuzzle() {
		var col = 0; //the column number.
		var row = 0; //the row number.
		for (var i = 0; i < 15; i++) {
			var piece = document.createElement("div");
			//the new puzzle
			piece.className = "puzzles";
			piece.id = "col" + col + "row" + row;
			var x = - col * 100;
			var y = - row * 100;
			piece.style.backgroundPosition = x + "px " + y + "px";
			position(col, row, piece);
			col++;
			if(col == 4){
				col = 0;
				row++;
			}
			piece.innerHTML = i + 1;
			document.getElementById("puzzlearea").appendChild(piece);
		}	
	}

	//to change the color of any adjacent tile to the blank when the 
	//cursor hovers on it.
	function colorIt() {
		var col = parseInt(window.getComputedStyle(this).left) / 100;
		//the column of the piece.
		var row = parseInt(window.getComputedStyle(this).top) / 100;
		//the row of the current piece.
		if(movable(col, row)){ 
			this.classList.add("movable");
		}else{
			this.classList.remove("movable");
		}
	}

	//to check if the current puzzle is next to the blank tile.
	function movable(col, row) {
		if((blankCol == col && Math.abs(row - blankRow) == 1) || 
			 (row == blankRow && Math.abs(blankCol - col) == 1)){
			return true;
		} else {
			return false;
		}
	}

	//triggerred when the current piece is clikced.
	//to call move() with the current puzzle as a parameter. 
	function moveIt(){
		move(this);
	}

	//to exchange the position of the puzzle and the blank space and also
	//update the puzzle's id when it's clicked.
	function move(puzzle) {
		var col = parseInt(window.getComputedStyle(puzzle).left) / 100;
		//the current puzzle's column.
		var row = parseInt(window.getComputedStyle(puzzle).top) / 100;
		//the current puzzle's row.
		if(movable(col, row)){
			puzzle.id = "col" + blankCol + "row" + blankRow;
			position(blankCol, blankRow, puzzle);
			blankCol = col;
			blankRow = row;
		}
	}

	//to put the puzzle in the right position acording to the given
	//clumn and row number.
	function position(col, row, puzzle) {
		puzzle.style.left = col * 100 + "px";
		puzzle.style.top = row * 100 + "px";
	}

	//triggerred when shuffle is clicked. follow an algorithm and each time moves
	//one random tile next to the blank space.
	function shuffle() {
		for (var h = 0; h < 1000; h++) {
			var neighbour = []; 
			//an array to keep track of the tiles next to the blank.
			var puzzles = document.querySelectorAll(".puzzles");
			//all the puzzles on page.
			for (var i = 0; i < puzzles.length; i++) {
				var col = parseInt(window.getComputedStyle(puzzles[i]).left) / 100;
				//the column of the current puzzle.
				var row = parseInt(window.getComputedStyle(puzzles[i]).top) / 100;
				//the row number of the current puzzle.
				if(movable(col, row)){
					neighbour.push(puzzles[i]);
				}
			}
		    var target = neighbour[parseInt(Math.random() * neighbour.length)];
		    //an random chosen element which is next to the blank area.
		   	move(target);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
		}
	}
}());