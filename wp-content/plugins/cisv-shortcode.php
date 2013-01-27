<?php
/*
Plugin Name: CISV Shortcode
Plugin URI: http://comeplay.no
Description: Adds shortcodes practical for CISV Norway.
Version: 0.1
Author: Henning Holgersen
Author URI: http://complay.no

Copyright 2007-2009 HENNING HOLGERSEN

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


function cisv_memberform($options) {

?>

<form method="POST" action="" target="_blank">

<fieldset>
<label id="id_name" for="id_name" class="smalltext">Fornavn:<b style="color: red;">*</b><input id="id_name" type="text" name="name" maxlength="64" /></label>
<label id="id_surname" for="id_surname" class="smalltext">Etternavn:<b style="color: red;">*</b><input id="id_surname" type="text" name="surname" maxlength="64" />
</label>


<label id="id_address1" class="bigtext">Adresse:<b style="color: red;">*</b><input id="id_address1" type="text" name="address1" maxlength="64" /> </label>


<label id="id_address2" class="bigtext2"><input id="id_address2" type="text" name="address2" maxlength="64" /></label>


<label id="postal_code_country_select">Postnummer<b style="color: red;">*</b></label>
<select name="postal_code_country_select" id="postal_code_country_select">

	<option value="no">NO</option>

</select>
<input onBlur="update_postalcode(&quot;postal_code&quot;)" name="postal_code" maxlength="4" type="text" id="id_postal_code" class="zipcode" />
<input type="text" disabled="disabled" id="postal_code_name" value="" style="border: 0px; background-color: white; color: #222222;" size="1" />





<label id="id_birth_day" class="bigtext">F&oslash;dselsdato<b style="color: red;">*</b></label>
<select name="birth_day" id="id_birth_day" class="select">

<option value="1">01</option>
<option value="2">02</option>
<option value="3">03</option>
<option value="4">04</option>
<option value="5">05</option>

<option value="6">06</option>
<option value="7">07</option>
<option value="8">08</option>
<option value="9">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>

<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>

<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>

<select name="birth_month" id="id_birth_month" class="select">
<option value="1">januar</option>
<option value="2">februar</option>
<option value="3">mars</option>
<option value="4">april</option>
<option value="5">mai</option>
<option value="6">juni</option>
<option value="7">juli</option>
<option value="8">august</option>

<option value="9">september</option>
<option value="10">oktober</option>
<option value="11">november</option>
<option value="12">desember</option>
</select>
<select name="birth_year" id="id_birth_year" class="select">
<option value="Velg">&Aring;r</option>
<option value="2009">2009</option>
<option value="2008">2008</option>
<option value="2007">2007</option>

<option value="2006">2006</option>
<option value="2005">2005</option>
<option value="2004">2004</option>
<option value="2003">2003</option>
<option value="2002">2002</option>
<option value="2001">2001</option>
<option value="2000">2000</option>
<option value="1999">1999</option>
<option value="1998">1998</option>

<option value="1997">1997</option>
<option value="1996">1996</option>
<option value="1995">1995</option>
<option value="1994">1994</option>
<option value="1993">1993</option>
<option value="1992">1992</option>
<option value="1991">1991</option>
<option value="1990">1990</option>
<option value="1989">1989</option>

<option value="1988">1988</option>
<option value="1987">1987</option>
<option value="1986">1986</option>
<option value="1985">1985</option>
<option value="1984">1984</option>
<option value="1983">1983</option>
<option value="1982">1982</option>
<option value="1981">1981</option>
<option value="1980">1980</option>

<option value="1979">1979</option>
<option value="1978">1978</option>
<option value="1977">1977</option>
<option value="1976">1976</option>
<option value="1975">1975</option>
<option value="1974">1974</option>
<option value="1973">1973</option>
<option value="1972">1972</option>
<option value="1971">1971</option>

<option value="1970">1970</option>
<option value="1969">1969</option>
<option value="1968">1968</option>
<option value="1967">1967</option>
<option value="1966">1966</option>
<option value="1965">1965</option>
<option value="1964">1964</option>
<option value="1963">1963</option>
<option value="1962">1962</option>

<option value="1961">1961</option>
<option value="1960">1960</option>
<option value="1959">1959</option>
<option value="1958">1958</option>
<option value="1957">1957</option>
<option value="1956">1956</option>
<option value="1955">1955</option>
<option value="1954">1954</option>
<option value="1953">1953</option>

<option value="1952">1952</option>
<option value="1951">1951</option>
<option value="1950">1950</option>
<option value="1949">1949</option>
<option value="1948">1948</option>
<option value="1947">1947</option>
<option value="1946">1946</option>
<option value="1945">1945</option>
<option value="1944">1944</option>

<option value="1943">1943</option>
<option value="1942">1942</option>
<option value="1941">1941</option>
<option value="1940">1940</option>
<option value="1939">1939</option>
<option value="1938">1938</option>
<option value="1937">1937</option>
<option value="1936">1936</option>
<option value="1935">1935</option>

<option value="1934">1934</option>
<option value="1933">1933</option>
<option value="1932">1932</option>
<option value="1931">1931</option>
<option value="1930">1930</option>
<option value="1929">1929</option>
<option value="1928">1928</option>
<option value="1927">1927</option>
<option value="1926">1926</option>

<option value="1925">1925</option>
<option value="1924">1924</option>
<option value="1923">1923</option>
<option value="1922">1922</option>
<option value="1921">1921</option>
<option value="1920">1920</option>
</select> 


<label id="id_email" class="bigtext">E-post<b style="color: red;">*</b></th>
<input type="text" name="email" id="id_email" /> 

<label id="phone_country_select" class="mixed">Mobiltelefon<b style="color: red;">*</b></label>
<select name="phone_country_select" id="phone_country_select">

	<option value="47">+47</option>

</select>

<input max_length="11" name="phone" maxlength="11" type="text" id="id_phone" size="12"  class="smallform" />


<label id="2_phone_country_select" class="mixed">Sekund&aelig;r telefon:</label>

 
<select name="2_phone_country_select" id="2_phone_country_select" />

	<option value="47">+47</option>

</select>

 <input max_length="11" name="phone2" maxlength="11" type="text" id="id_phone2" size="12" class="smallform" />

<label id="id_gender" class="smalltext">Kj&oslash;nn:<b style="color: red;">*</b>
<select name="gender" id="id_gender">
<option value="" selected="selected">---------</option>
<option value="m">Mann</option>
<option value="f">Kvinne</option>
</select> </label>


<input type="hidden" name="become_member" value="True" id="id_become_member" />

<input onBlur="update_recruiter()" name="recruiter" maxlength="9" type="hidden" id="id_recruiter" size="7" />
<input type="hidden" disabled="disabled" id="recruiter_name" value="" style="border: 0px; color: black; background-color: white;" /></td>

<input type="submit" value="Send inn" class="button" />
</fieldset>
</form>
<? 
}

add_shortcode('theform', 'cisv_memberform');




?>