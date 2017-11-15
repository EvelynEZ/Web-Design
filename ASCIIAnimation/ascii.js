/*
Jiaqi Zhang; Section: AJ; HW07
This is the javascript page for my ascii.html. It enables my webpage to control the 
behavior of the animation.
*/
"use strict"; //JavaScript strict mode.
(function() {
	//a number to keep track of which frame from the whole animation is played.
	var frameID = 0; 
	//the delay between each frames. The default delay time does not depend on this inital value.
	var speed = 0; 
	//a timer for the setInterval function.
	var timer = null;
	//the text that was in the box immediatly before "start" is clicked.
	var content = "";
	
	//Fires when the entire page is loaded, link buttons to behavioral functions. 
	//the end button is disabled.
	window.onload = function() {
		document.getElementById("end").disabled = true;
		document.getElementById("start").onclick = startPlay;
		document.getElementById("end").onclick = endPlay;
		document.getElementById("size").onchange = changeSize;
		document.getElementById("animation").onchange = chooseAnimation;
		//to set the speed when the page is loaded.
		changeSpeed();
		document.getElementById("speed").onchange = changeSpeed;
	};

	//Start the animation. Start button and choose box for animations are disabled once start is
	//clicked and end button is enabled.
	function startPlay() {
		document.getElementById("end").disabled = false; 
		this.disabled = true; //start button is disabled.
		document.getElementById("animation").disabled = true;
		//stores user's manually typed-in text or any pre-set animation.
		content = document.getElementById("mytextarea").value; 
		//plays each frame with a set time interval in between.
		timer = setInterval(playFrame, speed);
	}

	//Stops the animation. The text in the box immediatly before start was clicked is shown.
	//End button is disabled but start and animation select boxes are enabled.
	function endPlay() {
		clearInterval(timer);
		frameID = 0;
		this.disabled = true;
		document.getElementById("start").disabled = false;
		document.getElementById("animation").disabled = false;
		document.getElementById("mytextarea").value = content;
	}

	//Changes the font size of the text in the box to a given size.
	//When the choice is 'Custom', a pop-up box is presented to ask for a custom font-size.
	function changeSize() {
		//the size of user's choice.
		var size = parseInt(this.value) + "pt";
		if(size == "0pt") {
			size = prompt("Font size to use?(e.g. 10pt)"); 
		}
		//the content in the input textarea.
		var output = document.getElementById("mytextarea");
		output.style.fontSize = size;
	}

	//Outputs the text of choice in the text box.
	function chooseAnimation() {
		//the choice of animation to display.
		var anime = this.value;
		document.getElementById("mytextarea").value = ANIMATIONS[anime];
	}

	//plays the set of animation by seperating each frame with a special string and outputs 
	//each frame as required. When the end is reached, the animation loops back and repeats.
	function playFrame() {
		//the set of frames to play.
		var frames =  content.split("=====\n");
		//start the animation when reaching the end.
		if(frameID == frames.length){
			frameID = 0;
		}
		document.getElementById("mytextarea").value = frames[frameID];
		frameID++;		
	}

	//Changes the time interval between the presentation of each frame. 
	//Does not cause the animation to start if it wasn't in action.
	function changeSpeed() {
		//clear the interval only when it's already set.
		if(timer != null) {
			clearInterval(timer);
		}
		//get the speed from the checked radio box.
		speed = document.querySelector("input[type='radio']:checked").value;
		//only continues if the animation was in action.
		if(document.getElementById("start").disabled){
			timer = setInterval(playFrame, speed);
		}
	}

})();



