<?php

/* Copyright (C) 2001-2002	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2003		Jean-Louis Bergamo		<jlb@j1b.org>
 * Copyright (C) 2004-2012	Laurent Destailleur		<eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012	Regis Houssin			<regis@dolibarr.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *       \file       htdocs/adherents/index.php
 *       \ingroup    member
 *       \brief      Page accueil module adherents
 */
require("../main.inc.php");
require_once(DOL_DOCUMENT_ROOT . "/adherent/class/adherent.class.php");
require_once(DOL_DOCUMENT_ROOT . "/adherent/class/adherent_type.class.php");

$langs->load("companies");
$langs->load("members");


/*
 * View
 */

llxHeader('', $langs->trans("Members"), 'EN:Module_Foundations|FR:Module_Adh&eacute;rents|ES:M&oacute;dulo_Miembros');

$staticmember = new Adherent($db);
$statictype = new AdherentType($db);

print_fiche_titre($langs->trans("MembersArea"));

print '<table border="0" width="100%" class="notopnoleftnoright">';

$var = True;

$Adherents = array();
$AdherentsAValider = array();
$MemberUpToDate = array();
$AdherentsResilies = array();

$AdherentType = array();

// Liste les adherents
$sql = "SELECT t.rowid, t.libelle, t.cotisation,";
$sql.= " d.statut, count(d.rowid) as somme";
$sql.= " FROM " . MAIN_DB_PREFIX . "adherent_type as t";
$sql.= " LEFT JOIN " . MAIN_DB_PREFIX . "adherent as d";
$sql.= " ON t.rowid = d.fk_adherent_type";
$sql.= " AND d.entity IN (" . getEntity() . ")";
$sql.= " WHERE t.entity IN (" . getEntity() . ")";
$sql.= " GROUP BY t.rowid, t.libelle, t.cotisation, d.statut";

dol_syslog("index.php::select nb of members by type sql=" . $sql, LOG_DEBUG);
$result = $db->query($sql);
if ($result) {
	$num = $db->num_rows($result);
	$i = 0;
	while ($i < $num) {
		$objp = $db->fetch_object($result);

		$adhtype = new AdherentType($db);
		$adhtype->id = $objp->rowid;
		$adhtype->cotisation = $objp->cotisation;
		$adhtype->libelle = $objp->libelle;
		$AdherentType[$objp->rowid] = $adhtype;

		if ($objp->statut == -1) {
			$MemberToValidate[$objp->rowid] = $objp->somme;
		}
		if ($objp->statut == 1) {
			$MembersValidated[$objp->rowid] = $objp->somme;
		}
		if ($objp->statut == 0) {
			$MembersResiliated[$objp->rowid] = $objp->somme;
		}

		$i++;
	}
	$db->free($result);
}

$now = dol_now();

// List members up to date
// current rule: uptodate = the end date is in future whatever is type
// old rule: uptodate = if type does not need payment, that end date is null, if type need payment that end date is in future)
$sql = "SELECT count(*) as somme , d.fk_adherent_type";
$sql.= " FROM " . MAIN_DB_PREFIX . "adherent as d, " . MAIN_DB_PREFIX . "adherent_type as t";
$sql.= " WHERE d.entity IN (" . getEntity() . ")";
//$sql.= " AND d.statut = 1 AND ((t.cotisation = 0 AND d.datefin IS NULL) OR d.datefin >= ".$db->idate($now).')';
$sql.= " AND d.statut = 1 AND d.datefin >= " . $db->idate($now);
$sql.= " AND t.rowid = d.fk_adherent_type";
$sql.= " GROUP BY d.fk_adherent_type";

dol_syslog("index.php::select nb of uptodate members by type sql=" . $sql, LOG_DEBUG);
$result = $db->query($sql);
if ($result) {
	$num = $db->num_rows($result);
	$i = 0;
	while ($i < $num) {
		$objp = $db->fetch_object($result);
		$MemberUpToDate[$objp->fk_adherent_type] = $objp->somme;
		$i++;
	}
	$db->free();
}


print '<tr><td width="30%" class="notopnoleft" valign="top">';

/*
 * Statistics
 */

print '<table class="noborder" width="100%">';
print '<tr class="liste_titre"><td colspan="2">' . $langs->trans("Statistics") . '</td></tr>';
print '<tr><td align="center">';

$SommeA = 0;
$SommeB = 0;
$SommeC = 0;
$SommeD = 0;
$dataval = array();
$datalabels = array();
$i = 0;
foreach ($AdherentType as $key => $adhtype) {
	$datalabels[] = array($i, $adhtype->getNomUrl(0, dol_size(16)));
	$dataval['draft'][] = array($i, isset($MemberToValidate[$key]) ? $MemberToValidate[$key] : 0);
	$dataval['notuptodate'][] = array($i, isset($MembersValidated[$key]) ? $MembersValidated[$key] - $MemberUpToDate[$key] : 0);
	$dataval['uptodate'][] = array($i, isset($MemberUpToDate[$key]) ? $MemberUpToDate[$key] : 0);
	$dataval['resiliated'][] = array($i, isset($MembersResiliated[$key]) ? $MembersResiliated[$key] : 0);
	$SommeA+=isset($MemberToValidate[$key]) ? $MemberToValidate[$key] : 0;
	$SommeB+=isset($MembersValidated[$key]) ? $MembersValidated[$key] - $MemberUpToDate[$key] : 0;
	$SommeC+=isset($MemberUpToDate[$key]) ? $MemberUpToDate[$key] : 0;
	$SommeD+=isset($MembersResiliated[$key]) ? $MembersResiliated[$key] : 0;
	$i++;
}

$dataseries = array();
$dataseries[] = array('label' => $langs->trans("MenuMembersNotUpToDate"), 'data' => round($SommeB));
$dataseries[] = array('label' => $langs->trans("MenuMembersUpToDate"), 'data' => round($SommeC));
$dataseries[] = array('label' => $langs->trans("MembersStatusResiliated"), 'data' => round($SommeD));
$dataseries[] = array('label' => $langs->trans("MembersStatusToValid"), 'data' => round($SommeA));
$data = array('series' => $dataseries);
dol_print_graph('stats', 300, 180, $data, 1, 'pie', 1);
print '</td></tr>';
print '<tr class="liste_total"><td>' . $langs->trans("Total") . '</td><td align="right">';
print $SommeA + $SommeB + $SommeC + $SommeD;
print '</td></tr>';
print '</table>';

print '</td><td class="notopnoleftnoright" valign="top">';

$var = true;

// Summary of members by type
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>' . $langs->trans("MembersTypes") . '</td>';
print '<td align=right>' . $langs->trans("MembersStatusToValid") . '</td>';
print '<td align=right>' . $langs->trans("MenuMembersNotUpToDate") . '</td>';
print '<td align=right>' . $langs->trans("MenuMembersUpToDate") . '</td>';
print '<td align=right>' . $langs->trans("MembersStatusResiliated") . '</td>';
print "</tr>\n";

foreach ($AdherentType as $key => $adhtype) {
	$var = !$var;
	print "<tr $bc[$var]>";
	print '<td><a href="type.php?rowid=' . $adhtype->id . '">' . img_object($langs->trans("ShowType"), "group") . ' ' . $adhtype->getNomUrl(0, dol_size(16)) . '</a></td>';
	print '<td align="right">' . (isset($MemberToValidate[$key]) && $MemberToValidate[$key] > 0 ? $MemberToValidate[$key] : '') . ' ' . $staticmember->LibStatus(0, 0) . '</td>';
	print '<td align="right">' . (isset($MembersValidated[$key]) && ($MembersValidated[$key] - $MemberUpToDate[$key] > 0) ? $MembersValidated[$key] - $MemberUpToDate[$key] : '') . ' ' . $staticmember->LibStatus(1, 0) . '</td>';
	print '<td align="right">' . (isset($MemberUpToDate[$key]) && $MemberUpToDate[$key] > 0 ? $MemberUpToDate[$key] : '') . ' ' . $staticmember->LibStatus(1, array("dateEnd"=>$now+1000)) . '</td>';
	print '<td align="right">' . (isset($MembersResiliated[$key]) && $MembersResiliated[$key] > 0 ? $MembersResiliated[$key] : '') . ' ' . $staticmember->LibStatus(-1, 0) . '</td>';
	print "</tr>\n";
}
print '<tr class="liste_total">';
print '<td class="liste_total">' . $langs->trans("Total") . '</td>';
print '<td class="liste_total" align="right">' . $SommeA . ' ' . $staticmember->LibStatus(0, 0) . '</td>';
print '<td class="liste_total" align="right">' . $SommeB . ' ' . $staticmember->LibStatus(1, 0) . '</td>';
print '<td class="liste_total" align="right">' . $SommeC . ' ' . $staticmember->LibStatus(1, array("dateEnd"=>$now+1000)) . '</td>';
print '<td class="liste_total" align="right">' . $SommeD . ' ' . $staticmember->LibStatus(-1, 0) . '</td>';
print '</tr>';

print "</table>\n";
print "<br>\n";


// List of subscription by year
$Total = array();
$Number = array();
$tot = 0;
$numb = 0;

$sql = "SELECT c.cotisation, c.dateadh";
$sql.= " FROM " . MAIN_DB_PREFIX . "adherent as d, " . MAIN_DB_PREFIX . "cotisation as c";
$sql.= " WHERE d.entity IN (" . getEntity() . ")";
$sql.= " AND d.rowid = c.fk_adherent";
if (isset($date_select) && $date_select != '') {
	$sql .= " AND dateadh LIKE '$date_select%'";
}
$result = $db->query($sql);
if ($result) {
	$num = $db->num_rows($result);
	$i = 0;
	while ($i < $num) {
		$objp = $db->fetch_object($result);
		$year = dol_print_date($db->jdate($objp->dateadh), "%Y");
		$Total[$year] = (isset($Total[$year]) ? $Total[$year] : 0) + $objp->cotisation;
		$Number[$year] = (isset($Number[$year]) ? $Number[$year] : 0) + 1;
		$tot+=$objp->cotisation;
		$numb+=1;
		$i++;
	}
}

print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>' . $langs->trans("Subscriptions") . '</td>';
print '<td align="right">' . $langs->trans("Number") . '</td>';
print '<td align="right">' . $langs->trans("AmountTotal") . '</td>';
print '<td align="right">' . $langs->trans("AmountAverage") . '</td>';
print "</tr>\n";

$var = true;
krsort($Total);
foreach ($Total as $key => $value) {
	$var = !$var;
	print "<tr $bc[$var]>";
	print "<td><a href=\"cotisations.php?date_select=$key\">$key</a></td>";
	print "<td align=\"right\">" . $Number[$key] . "</td>";
	print "<td align=\"right\">" . price($value) . "</td>";
	print "<td align=\"right\">" . price(price2num($value / $Number[$key], 'MT')) . "</td>";
	print "</tr>\n";
}

// Total
print '<tr class="liste_total">';
print '<td>' . $langs->trans("Total") . '</td>';
print "<td align=\"right\">" . $numb . "</td>";
print '<td align="right">' . price($tot) . "</td>";
print "<td align=\"right\">" . price(price2num($numb > 0 ? ($tot / $numb) : 0, 'MT')) . "</td>";
print "</tr>\n";
print "</table><br>\n";

print '</td></tr>';
print '</table>';

print dol_fiche_end();

llxFooter();
$db->close();
?>