/*
 * ========================================================================
 * Copyright (C) 2008 Sadaoui Akim
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 * ========================================================================
 */
var nbEleves = 25;

function hide()
{
	if(document.getElementById("addClass").style.visibility == "hidden")
		document.getElementById("addClass").style.visibility = "visible";
	else
		document.getElementById("addClass").style.visibility = "hidden";
}

function addEleves()
{
	nbEleves = document.getElementById("nb_el").value;
	if(nbEleves < 50)
		nbEleves ++;
	document.getElementById("nb_el").value = nbEleves;
}

function removeEleves()
{
	nbEleves = document.getElementById("nb_el").value;
	if(nbEleves > 0)
		nbEleves--;
	document.getElementById("nb_el").value = nbEleves;
}

function showInput()
{
	nbEleves = document.getElementById("nb_el").value;
	if(nbEleves >= 0 && nbEleves <51)
	{
		var j = 0; var k = 10; var l = 20; var m = 30;
		document.getElementById("eleves").innerHTML = "";
		for(i = 1; i <= nbEleves; i++)
		{
			j = j+40; k = k+40; l = l+40; m = m+40;
			document.getElementById("eleves").innerHTML = document.getElementById("eleves").innerHTML+"<label for=\"name_eleve"+i+"\">Nom : </label><input type=\"text\" name=\"name_eleve"+i+"\" id=\"name_eleve"+i+"\" tabindex=\""+j+"\" /><label for=\"surname_eleve"+i+"\">Pr&eacute;nom : </label><input type=\"text\" name=\"surname_eleve"+i+"\" id=\"surname_eleve"+i+"\" tabindex=\""+k+"\" /><label for=\"sex_eleve"+i+"\">Sexe : </label><select name=\"sex_eleve"+i+"\" id=\"sex_eleve"+i+"\" tabindex=\""+l+"\" /><option value=\"1\" selected=\"selected\">Gar&ccedil;on</option><option value=\"0\">Fille</option></select><label for=\"birth_eleve"+i+"\">Date de naissance : </label><input type=\"text\" name=\"birth_eleve"+i+"\" id=\"birth_eleve"+i+"\" tabindex=\""+m+"\" /><br />\n";
		}
	}
}

document.getElementById("hiddener").onclick = hide;
document.getElementById("show").onclick = showInput;
document.getElementById("moreEl").onclick = addEleves;
document.getElementById("lessEl").onclick = removeEleves;
document.getElementById("nb_el").value = nbEleves;

function check() {
	if (document.formAdd.name.value == "")
	{
		document.formAdd.name.style.backgroundColor = "#F3C200";
		document.formAdd.name.focus();
		return false;
	}
	else
	{
		document.formAdd.name.style.backgroundColor = "#FFFFFF";
		for(i=1;i<=document.getElementById("nb_el").value;i++)
		{
			if (document.getElementById("name_eleve"+i).value == "")
			{
				if(i>1)
				{
					j = i-1;
					document.getElementById("surname_eleve"+j).style.backgroundColor = "#FFFFFF";
				}
				document.getElementById("name_eleve"+i).style.backgroundColor = "#F3C200";
				document.getElementById("name_eleve"+i).focus();
				return false;
			}
			else if (document.getElementById("surname_eleve"+i).value == "")
			{
				document.getElementById("name_eleve"+i).style.backgroundColor = "#FFFFFF";
				document.getElementById("surname_eleve"+i).style.backgroundColor = "#F3C200";
				document.getElementById("surname_eleve"+i).focus();
				return false;
			}
		}
	}
	return true;
}
