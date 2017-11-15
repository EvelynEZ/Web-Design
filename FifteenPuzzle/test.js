"use strict";
(function () {
	var blankCol = 4;
	var blankRow = 4;
	var movable = false;                                                                                      

	window.onload = function() {
		creatPuzzle();
		document.getElementById("shufflebutton").onclick = shuffle;

		var puzzles = document.querySelectorAll(".puzzles");
		//redundancy
		for (var i = 0; i < puzzles.length; i++) {
			puzzles[i].onmouseover = colorIt;	
			puzzles[i].onclick = moveIt;
		}
	};

	function creatPuzzle() {
		var col = 1;
		var row = 1;
		for (var i = 0; i < 15; i++) {
			var piece = document.createElement("div");
			piece.className = "puzzles";
			piece.id = "col" + col + "row" + row;
			var p = document.createElement("p");
			p.innerHTML = i + 1;
			var x = - (col - 1) * 100;
			var y = - (row - 1) * 100;
			piece.style.backgroundPosition = x + "px " + y + "px";
			col++;
			if(col == 5){
				col = 1;
				row++;
			}
			piece.appendChild(p);
			document.getElementById("puzzlearea").appendChild(piece);
			position(piece);
		}	
	}

	function colorIt() {
		var thisCol = parseInt(this.id.charAt(3));
		var thisRow = parseInt(this.id.charAt(7));
		if((blankCol == thisCol && Math.abs(thisRow - blankRow) == 1) || 
			 (thisRow == blankRow && Math.abs(blankCol - thisCol) == 1)){
			movable = true;
			this.classList.add("movable");
		} else {
			movable = false;
			this.classList.remove("movable");
		}

	}

	function moveIt() {
		if(movable){
			idSwitch(this);
			position(this);
		}
	}

	function position(puzzle) {
		puzzle.style.left = (parseInt(puzzle.id.charAt(3)) - 1) * 100 + "px";
		puzzle.style.top = (parseInt(puzzle.id.charAt(7)) - 1) * 100 + "px";
		
	}

	function idSwitch(puzzle){
		var id = puzzle.id;
		puzzle.id = "col" + blankCol + "row" + blankRow;
		blankCol = id.charAt(3);
		blankRow = id.charAt(7);
	}

	function shuffle() {
		for (var h = 0; h < 1000; h++) {
			var neighbour = [];
			var puzzles = document.querySelectorAll(".puzzles");
			//re
			for(var j = 0; j < puzzles.length; j++) {
				if(movable){
					neighbour.push(puzzles[j]);
				}
			}
		    var target = neighbour[parseInt(Math.random() * neighbour.length)];
		   	idSwitch(target);
		   	position(target);
		}
	}
}());