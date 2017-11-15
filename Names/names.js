"use strict";
/*
Jiaqi Zhang; AJ; HW09
This is the js page for names.html. It displays meaning, popularity ranking,
and celebrities with given baby names based on info from SSA. When the page
is loaded, a list of baby names of choice is loaded.
*/
(function() {
	window.onload = function() {
		newXML(displayNames, "type=list");
		document.getElementById("search").onclick = fetchNameData;
	};

	//This function takes a function name and a query inside a url as parameters,
	//creates a new Ajax object and calls the function with the name from the 
	//parameter and passes to the url with the given queries. If error occurs durinf
	//the procedure, an error message would be generated.
	function newXML (method, query){
		var ajax = new XMLHttpRequest();
		ajax.onload = method;
		ajax.onerror = function() {
			error(this.responseText);
		};
		ajax.open("GET", "https://webster.cs.washington.edu/cse154/babynames.php?" + query, true);
		ajax.send();
	}

	//Takes all the names from the returned XML list and put each one 
	//in the html selection section.
	function displayNames() {
		//to access the drop down list.
		var selectionBox = document.getElementById("allnames");
		//to split the response string into seperate names.
		var names = this.responseText.split("\n");
		for (var i = 0; i < names.length; i++) {
			//new <option> object.
			var option = document.createElement("option");
			option.innerHTML = names[i];
			option.value = names[i];
			selectionBox.appendChild(option);
		}
		//The loading image is hidden when the list of names is done loading.
		document.getElementById("loadingnames").style.display = "none";
		selectionBox.disabled = "";
	}

	//Called when "search" is clicked. Only fetches data and proceeds when the chosen
	//name is not the default text with empty value.
	function fetchNameData() {
		//to get the name passed in the drop down box.
		var name = document.getElementById("allnames").value;
		//only proceeds when the name has a valid value.
		if (name != ""){
			//During the search, the result area is shown as well as all 
			//the loading images in this div.
			document.getElementById("resultsarea").style.display = "block";
			document.getElementById("meaning").innerHTML = "";
			document.getElementById("graph").innerHTML = "";
			document.getElementById("celebs").innerHTML = "";
			document.getElementById("norankdata").style.display = "none";
			loadingImg("");
			//fetch meaning data by using Ajax.
			newXML(showMeaning, "type=meaning&name=" + name);

			//the chosen gender passed in the radio box.
			var gender;
			var male = document.getElementById("genderm");
			if(male.checked){
				gender = "m";
			} else {
				gender = "f";
			}

			//fetch the popularity ranking data using Ajax.
			newXML(showRank, "type=rank&name=" + name + "&gender=" + gender);
			//fetch the celebrities list with first name the same as the given
			//baby name.
			newXML(showCeleb, "type=celebs&name=" + name + "&gender=" + gender);
		} 
	}

	//When the name has valid value, this function outputs name's meaning.
	//if the the response status is not 200, an error message will be generated.
	function showMeaning() {
		if(this.status == 200){
			document.getElementById("meaning").innerHTML = this.responseText;
			document.getElementById("loadingmeaning").style.display = "none";
		} else {
			error(this.reponseText);
		}
	}

	//Ouputs ranking info of the name for the past century as a table.
	//If the name and gender combination cannot be found, an error message is
	//generated.
	function showRank() {
		//to access the graphing area.
		var graph = document.getElementById("graph");
		if (this.status == 200) {
			//the valid years of ranking 
			var years = this.responseXML.querySelectorAll("rank");
			//the first row on the table.
			var row1 = document.createElement("tr");
			for(var i = 0; i < years.length; i++) {
				//each column for a new year.
				var col = document.createElement("th");
				col.innerHTML = years[i].getAttribute("year");
				row1.appendChild(col);
			}
			graph.appendChild(row1);
			//the second row on the table.
			var row2 = document.createElement("tr");
			for (var j = 0; j < years.length; j++) {
				//each section in the column for the ranking.
				var td = document.createElement("td");
				//the div inside of each column seciton.
				var div = document.createElement("div");
				//the ranking
				var rank = years[j].textContent;
				div.innerHTML = rank;
				if(rank > 0) {
					div.style.height = parseInt((1000 - rank) / 4) + "px";
				} 
				if(rank <=10 && rank >= 1){
					div.style.color = "red";
				}
				td.appendChild(div);
				row2.appendChild(td);
			}
			graph.appendChild(row2);
		} else if(this.status == 410) {
			document.getElementById("norankdata").style.display = "block";
		} else{
			error(this.responseText);
		}
		document.getElementById("loadinggraph").style.display = "none";
	}

	//Oupputs all the celebrities with firstname the same as the chosen baby name.
	//If no celebrity with given first name is found, the seciton should be empty.
	function showCeleb() {
		//The list of applicable actors.
		var actorList = JSON.parse(this.responseText);
		//the celebrities section from the html page.
		var celeb = document.getElementById("celebs");
		for (var i = 0; i < actorList.actors.length; i++) {
			//actor's name from the actors list.
			var actor = actorList.actors[i];
			//a new list object
			var li = document.createElement("li");
			var string = actor.firstName + " " + actor.lastName + " (" + 
												actor.filmCount + " films)"; 
			li.innerHTML = string;
			celeb.appendChild(li);
		}
		document.getElementById("loadingcelebs").style.display = "none";
	}

	//Error handeling function. Puts the given error message in the itended div.
	function error(errorMsg) {
		document.getElementById("errors").innerHTML = errorMsg;
		loadingImg("none");
	}

	//makes the loading images disappear or appear based on the parameter's request.
	function loadingImg (display) {
		var loadingImages = document.querySelectorAll("#resultsarea .loading");
		for (var i = 0; i < loadingImages.length; i++) {
			loadingImages[i].style.display = display;
		}
	}
})();



