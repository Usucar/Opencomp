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
var nbSousmatieres = 0;

function addSousmatieres()
{
	nbSousmatieres = document.getElementById("nb_sous").value;
	if(nbSousmatieres < 50)
		nbSousmatieres ++;
	document.getElementById("nb_sous").value = nbSousmatieres;
}

function removeSousmatieres()
{
	nbSousmatieres = document.getElementById("nb_sous").value;
	if(nbSousmatieres > 0)
		nbSousmatieres --;
	document.getElementById("nb_sous").value = nbSousmatieres;
}

function showInput()
{
	nbSousmatieres = document.getElementById("nb_sous").value;
	if(nbSousmatieres >= 0 && nbSousmatieres <51)
	{
		document.getElementById("sousmatieres").innerHTML = "";
		for(i = 1; i <= nbSousmatieres; i++)
		{
			j = i*10;
			document.getElementById("sousmatieres").innerHTML = document.getElementById("sousmatieres").innerHTML+"<label for=\"name_sous"+j+"\">Nom : </label><input type=\"text\" name=\"name_sous"+j+"\" id=\"name_sous"+j+"\" tabindex=\""+j+"\" />\n";
		}
	}
}

document.getElementById("show").onclick = showInput;
document.getElementById("moreSous").onclick = addSousmatieres;
document.getElementById("lessSous").onclick = removeSousmatieres;
document.getElementById("nb_sous").value = nbSousmatieres;
