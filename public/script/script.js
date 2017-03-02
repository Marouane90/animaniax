"use strict";
var listeDeCourses= [];

function createLine(newLine)
{
	var line = '<td>'+
				'<button data-line="'+newLine+'" class="delete_'+newLine+'">X</button>'+
			'</td>'+

			'<td>'+
			'<input data-line="'+newLine+'" type="text" class="name_'+newLine+'">'+
			'</td>'+
			'<td>'+
			'<input data-line="'+newLine+'" type="number" class="quantity_'+newLine+'">'+
			'</td>'+
			'<td>'+
			'<select data-line="'+newLine+'" class="unity_'+newLine+'">'+
				'<option>L</option>'+
				'<option>Kg</option>'+
			'</select>'+
			'</td>'+
			
			'<td>'+
			'<input data-line="'+newLine+'" type="checkbox" class="checked_'+newLine+'" />'+
			'</td>';

	var tr = document.createElement('tr');
	tr.innerHTML = line;
	tr.classList.add("line_"+newLine);
	document.querySelector('tbody').appendChild(tr);
	manageEvent(newLine);
}

function element()
{
	var line = parseInt(this.dataset.line);
	var name = document.querySelector(".name_"+line).value;
	var checked = document.querySelector(".checked_"+line).checked;
	var unity = document.querySelector(".unity_"+line).value;
	var quantity = document.querySelector(".quantity_"+line).value;


	var elem = {}
	elem.name= name;
	elem.quantity= quantity;
	elem.checked= checked;
	elem.unity= unity;
	
	if (listeDeCourses[line] == undefined)
	{
		createLine(line +1);
	}

	listeDeCourses[line]= elem;
	
	var jsonCourses = JSON.stringify(listeDeCourses);
	localStorage.liste = jsonCourses;
}

function removeElem()
{
	var line = parseInt(this.dataset.line);
	if (listeDeCourses[line] !== undefined)
	{
		listeDeCourses.splice(line, 1);
		var jsonCourses = JSON.stringify(listeDeCourses);
		localStorage.setItem('liste', jsonCourses);
		location.reload(true);
	}
}

function manageEvent (nbrLine)
{
	document.querySelector(".name_"+nbrLine).onkeyup = element;
	document.querySelector(".checked_"+nbrLine).onclick = element;
	document.querySelector(".unity_"+nbrLine).onchange = element;
	document.querySelector(".quantity_"+nbrLine).onkeyup = element;
	document.querySelector(".delete_"+nbrLine).onclick = removeElem;
}
function loadList()
{
	var jsonStr = localStorage.liste;
	if (jsonStr != undefined)
	{
		listeDeCourses = JSON.parse(jsonStr);
		var count = 0;
		while (count < listeDeCourses.length)
		{
			document.querySelector(".name_"+count).value= listeDeCourses[count].name;
			document.querySelector(".checked_"+count).value= listeDeCourses[count].checked;
			document.querySelector(".unity_"+count).value= listeDeCourses[count].unity;
			document.querySelector(".quantity_"+count).value= listeDeCourses[count].quantity;

			createLine(count + 1);
			count++;
		}
	}
}
manageEvent(0);
loadList();
