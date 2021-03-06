<?php
/* Copyright (C) 2001-2004	Rodolphe Quiedeville	<rodolphe@quiedeville.org>
 * Copyright (C) 2004-2012	Laurent Destailleur	<eldy@users.sourceforge.net>
* Copyright (C) 2005-2012	Regis Houssin		<regis.houssin@capnetworks.com>
* Copyright (C) 2011-2012      Herve Prot              <herve.prot@symeos.com>
* Copyright (C) 2011   	Juanjo Menent		<jmenent@2byte.es>
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 3 of the License, or
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

define('NOCSRFCHECK', 1); // This is login page. We must be able to go on it from another web site.

require("./main.inc.php");
require_once(DOL_DOCUMENT_ROOT . "/core/class/html.formother.class.php");
require_once(DOL_DOCUMENT_ROOT . "/agenda/class/agenda.class.php");

// If not defined, we select menu "home"
$action = GETPOST('action');

// Add index hook
$hookmanager->initHooks(array('index'));


/*
 * Actions
*/

// Check if company name is defined (first install)
if (!isset($conf->global->MAIN_INFO_SOCIETE_NOM) || empty($conf->global->MAIN_INFO_SOCIETE_NOM)) {
	header("Location: " . DOL_URL_ROOT . "/admin/company.php?mainmenu=home&leftmenu=setup&mesg=setupnotcomplete");
	exit;
}

/*
 * View
*/

llxHeader();

if (!empty($conf->global->MAIN_MOTD)) {
	$conf->global->MAIN_MOTD = preg_replace('/<br(\s[\sa-zA-Z_="]*)?\/?>/i', '<br>', $conf->global->MAIN_MOTD);
	if (!empty($conf->global->MAIN_MOTD)) {
		print '<div class="row">';
		print '<div class="twelve columns">';
		print "\n<!-- Start of welcome text -->\n";
		print '<table width="100%" class="notopnoleftnoright"><tr><td>';
		print dol_htmlentitiesbr($conf->global->MAIN_MOTD);
		print '</td></tr></table><br>';
		print "\n<!-- End of welcome text -->\n";
		print '</div>';
		print '</div>';
	}
}

print_fiche_titre($langs->trans("Dashboard"), true);
?>
<div class="dashboard">
	<div class="columns">
		<div class="nine-columns twelve-columns-mobile chart">
			<div id="demo-chart" style="height: 280px; min-width: 100px"></div>
		</div>

		<div class="three-columns twelve-columns-mobile new-row-mobile">
			<ul class="stats split-on-mobile">
				<li><a href="#"> <strong>-</strong> new <br>accounts
				</a></li>
				<li><a href="#"> <strong>-</strong> referred new <br>accounts
				</a></li>
				<li><strong>-</strong> new <br>items</li>
				<li><strong>-</strong> new <br>comments</li>
			</ul>
		</div>
	</div>
</div>
<?php
print '<div class="with-padding">';
print '<div class="columns">';

/*
 * Informations area
*/

print column_start("four");
print start_box($langs->trans("Informations"), 'icon-user');
print '<table class="noborder" width="100%">';
print '<tr ' . $bc[false] . '>';
print '<td nowrap="nowrap">' . $langs->trans("User") . '</td><td>' . $user->getNomUrl(0) . '</td></tr>';
print '<tr ' . $bc[true] . '>';
print '<td nowrap="nowrap">' . $langs->trans("PreviousConnexion") . '</td><td>';
if ($user->LastConnection)
	print dol_print_date($user->LastConnection, "dayhour");
else
	print $langs->trans("Unknown");
print '</td>';
print "</tr>\n";
print "</table>\n";
print end_box();
print column_end();

print column_start("four");
print column_end();

// print today action
print column_start("four");
$agenda = new Agenda($db);
$agenda->print_week(dol_now());
print column_end();


/*
 $rowspan = 0;
$dashboardlines = array();
print start_box($langs->trans("SpeedealingWorkBoard"), "eight", "16-Cloud.png");
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<th class="liste_titre"colspan="2">' . $langs->trans("SpeedealingWorkBoard") . '</th>';
print '<th class="liste_titre"align="right">' . $langs->trans("Number") . '</th>';
print '<th class="liste_titre"align="right">' . $langs->trans("Late") . '</th>';
print '<th class="liste_titre">&nbsp;</th>';
print '<th class="liste_titre"width="20">&nbsp;</th>';
print '</tr>';
//
// Do not include sections without management permission
//
// Number of actions to do (late)
if ($conf->agenda->enabled && $user->rights->agenda->myactions->read) {
include_once(DOL_DOCUMENT_ROOT . "/agenda/class/agenda.class.php");
$board = new Agenda($db);
$board->load_board($user);
$board->warning_delay = $conf->actions->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("ActionsToDo");
$board->url = DOL_URL_ROOT . '/agenda/listactions.php?status=todo&mainmenu=agenda';
$board->img = img_object($langs->trans("Actions"), "action");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of customer orders a deal
if ($conf->commande->enabled && $user->rights->commande->lire) {
include_once(DOL_DOCUMENT_ROOT . "/commande/class/commande.class.php");
$board = new Commande($db);
$board->load_board($user);
$board->warning_delay = $conf->commande->client->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("OrdersToProcess");
$board->url = DOL_URL_ROOT . '/commande/liste.php?viewstatut=-2';
$board->img = img_object($langs->trans("Orders"), "order");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of suppliers orders a deal
if ($conf->fournisseur->enabled && $user->rights->fournisseur->commande->lire) {
include_once(DOL_DOCUMENT_ROOT . "/fourn/class/fournisseur.commande.class.php");
$board = new CommandeFournisseur($db);
$board->load_board($user);
$board->warning_delay = $conf->commande->fournisseur->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("SuppliersOrdersToProcess");
$board->url = DOL_URL_ROOT . '/fourn/commande/index.php';
$board->img = img_object($langs->trans("Orders"), "order");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of commercial proposals opened (expired)
if ($conf->propal->enabled && $user->rights->propale->lire) {
$langs->load("propal");

include_once(DOL_DOCUMENT_ROOT . "/comm/propal/class/propal.class.php");
$board = new Propal($db);
$board->load_board($user, "opened");
$board->warning_delay = $conf->propal->cloture->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("PropalsToClose");
$board->url = DOL_URL_ROOT . '/comm/propal/list.php?viewstatut=1';
$board->img = img_object($langs->trans("Propals"), "propal");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of commercial proposals CLOSED signed (billed)
if ($conf->propal->enabled && $user->rights->propale->lire) {
$langs->load("propal");

include_once(DOL_DOCUMENT_ROOT . "/comm/propal/class/propal.class.php");
$board = new Propal($db);
$board->load_board($user, "signed");
$board->warning_delay = $conf->propal->facturation->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("PropalsToBill");
$board->url = DOL_URL_ROOT . '/comm/propal/list.php?viewstatut=2';
$board->img = img_object($langs->trans("Propals"), "propal");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of services enabled (delayed)
if ($conf->contrat->enabled && $user->rights->contrat->lire) {
$langs->load("contracts");

include_once(DOL_DOCUMENT_ROOT . "/contrat/class/contrat.class.php");
$board = new Contrat($db);
$board->load_board($user, "inactives");
$board->warning_delay = $conf->contrat->services->inactifs->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("BoardNotActivatedServices");
$board->url = DOL_URL_ROOT . '/contrat/services.php?mainmenu=commercial&leftmenu=contracts&mode=0';
$board->img = img_object($langs->trans("Contract"), "contract");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of active services (expired)
if ($conf->contrat->enabled && $user->rights->contrat->lire) {
$langs->load("contracts");

include_once(DOL_DOCUMENT_ROOT . "/contrat/class/contrat.class.php");
$board = new Contrat($db);
$board->load_board($user, "expired");
$board->warning_delay = $conf->contrat->services->expires->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("BoardRunningServices");
$board->url = DOL_URL_ROOT . '/contrat/services.php?mainmenu=commercial&leftmenu=contracts&mode=4&filter=expired';
$board->img = img_object($langs->trans("Contract"), "contract");
$rowspan++;
$dashboardlines[] = $board;
}
// Number of invoices customers (has paid)
if ($conf->facture->enabled && $user->rights->facture->lire) {
$langs->load("bills");

include_once(DOL_DOCUMENT_ROOT . "/compta/facture/class/facture.class.php");
$board = new Facture($db);
$board->load_board($user);
$board->warning_delay = $conf->facture->client->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("CustomerBillsUnpaid");
$board->url = DOL_URL_ROOT . '/compta/facture/impayees.php';
$board->img = img_object($langs->trans("Bills"), "bill");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of supplier invoices (has paid)
if ($conf->fournisseur->enabled && $conf->facture->enabled && $user->rights->facture->lire) {
$langs->load("bills");

include_once(DOL_DOCUMENT_ROOT . "/fourn/class/fournisseur.facture.class.php");
$board = new FactureFournisseur($db);
$board->load_board($user);
$board->warning_delay = $conf->facture->fournisseur->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("SupplierBillsToPay");
$board->url = DOL_URL_ROOT . '/fourn/facture/index.php?filtre=paye:0';
$board->img = img_object($langs->trans("Bills"), "bill");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of transactions to conciliate
if ($conf->banque->enabled && $user->rights->banque->lire && !$user->societe_id) {
$langs->load("banks");

include_once(DOL_DOCUMENT_ROOT . "/compta/bank/class/account.class.php");
$board = new Account($db);
$found = $board->load_board($user);
if ($found > 0) {
$board->warning_delay = $conf->bank->rappro->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("TransactionsToConciliate");
$board->url = DOL_URL_ROOT . '/compta/bank/index.php?leftmenu=bank&mainmenu=bank';
$board->img = img_object($langs->trans("TransactionsToConciliate"), "payment");
$rowspan++;
$dashboardlines[] = $board;
}
}

// Number of cheque to send
if ($conf->banque->enabled && $user->rights->banque->lire && !$user->societe_id) {
$langs->load("banks");

include_once(DOL_DOCUMENT_ROOT . "/compta/paiement/cheque/class/remisecheque.class.php");
$board = new RemiseCheque($db);
$board->load_board($user);
$board->warning_delay = $conf->bank->cheque->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("BankChecksToReceipt");
$board->url = DOL_URL_ROOT . '/compta/paiement/cheque/index.php?leftmenu=checks&mainmenu=accountancy';
$board->img = img_object($langs->trans("BankChecksToReceipt"), "payment");
$rowspan++;
$dashboardlines[] = $board;
}

// Number of foundation members
if ($conf->adherent->enabled && $user->rights->adherent->lire && !$user->societe_id) {
$langs->load("members");

include_once(DOL_DOCUMENT_ROOT . "/adherent/class/adherent.class.php");
$board = new Adherent($db);
$board->load_board($user);
$board->warning_delay = $conf->adherent->cotisation->warning_delay / 60 / 60 / 24;
$board->label = $langs->trans("MembersWithSubscriptionToReceive");
$board->url = DOL_URL_ROOT . '/adherent/list.php?mainmenu=members';
$board->img = img_object($langs->trans("Members"), "user");
$rowspan++;
$dashboardlines[] = $board;
}

// Calculate total nb of late
$totallate = 0;
foreach ($dashboardlines as $key => $board) {
if ($board->nbtodolate > 0)
	$totallate+=$board->nbtodolate;
}

// Show dashboard
$var = true;
foreach ($dashboardlines as $key => $board) {
$var = !$var;
print '<tr ' . $bc[$var] . '><td width="16">' . $board->img . '</td><td>' . $board->label . '</td>';
print '<td align="right"><a href="' . $board->url . '">' . $board->nbtodo . '</a></td>';
print '<td align="right">';
print '<a href="' . $board->url . '">';
print $board->nbtodolate;
print '</a></td>';
print '<td align="left">';
if ($board->nbtodolate > 0)
	print img_picto($langs->trans("NActionsLate", $board->nbtodolate), "warning");
else
	print '&nbsp;';
print '</td>';
print '<td nowrap="nowrap" align="right">';
print ' (>' . ceil($board->warning_delay) . ' ' . $langs->trans("days") . ')';
print '</td>';
print '</tr>';
print "\n";
}


print '</table>';   // End table array
print end_box();
*/
/*
 * Dashboard Speedealing states (statistics)
* Hidden for external users
*/
$langs->load("commercial");
$langs->load("bills");
$langs->load("orders");

/*if ($user->societe_id == 0) {
 print start_box($langs->trans("SpeedealingStateBoard"), 'four', '16-Graph.png');
print '<table class="noborder" width="100%">';

$var = true;

// Condition to be checked for each display line dashboard
$conditions = array(
		!empty($conf->societe->enabled) && $user->rights->societe->lire && empty($conf->global->SOCIETE_DISABLE_CUSTOMERS_STATS),
		!empty($conf->societe->enabled) && $user->rights->societe->lire && empty($conf->global->SOCIETE_DISABLE_PROSPECTS_STATS),
		!empty($conf->societe->enabled) && $user->rights->societe->lire && empty($conf->global->SOCIETE_DISABLE_SUSPECTS_STATS),
		!empty($conf->fournisseur->enabled) && $user->rights->fournisseur->lire && empty($conf->global->SOCIETE_DISABLE_SUPPLIERS_STATS),
		!empty($conf->adherent->enabled) && $user->rights->adherent->lire,
		!empty($conf->product->enabled) && $user->rights->produit->lire,
		!empty($conf->service->enabled) && $user->rights->service->lire,
		!empty($conf->propal->enabled) && $user->rights->propale->lire,
		!empty($conf->lead->enabled) && $user->rights->lead->lire,
		!empty($conf->commande->enabled) && $user->rights->commande->lire,
		!empty($conf->facture->enabled) && $user->rights->facture->lire,
		!empty($conf->societe->enabled) && $user->rights->contrat->activer);
// Class file containing the method load_state_board for each line
$includes = array("/societe/class/societe.class.php",
		"/societe/class/societe.class.php",
		"/societe/class/societe.class.php",
		"/fourn/class/fournisseur.class.php",
		"/adherent/class/adherent.class.php",
		"/product/class/product.class.php",
		"/product/class/service.class.php",
		"/comm/propal/class/propal.class.php",
		"/lead/class/lead.class.php",
		"/commande/class/commande.class.php",
		"/compta/facture/class/facture.class.php",
		"/contrat/class/contrat.class.php");
// Name class containing the method load_state_board for each line
$classes = array('Societe',
		'Societe',
		'Societe',
		'Fournisseur',
		'Adherent',
		'Product',
		'Service',
		'Propal',
		'Lead',
		'Commande',
		'Facture',
		'Contrat');
// Cle array returned by the method load_state_board for each line
$keys = array('customer',
		'prospect',
		'suspect',
		'suppliers',
		'members',
		'products',
		'services',
		'proposals',
		'leads',
		'orders',
		'invoices',
		'Contracts');
// Dashboard Icon lines
$icons = array('company',
		'company',
		'company',
		'company',
		'user',
		'product',
		'service',
		'propal',
		'lead',
		'order',
		'bill',
		'order');
// Translation keyword
$titres = array("Customers",
		"Prospects",
		"Suspects",
		"Suppliers",
		"Members",
		"Products",
		"Services",
		"CommercialProposals",
		"Leads",
		"CustomersOrders",
		"BillsCustomers",
		"Contracts");
// Dashboard Link lines
$links = array('/comm/list.php?type=2',
		'/comm/list.php?type=1',
		'/comm/list.php?type=0',
		'/fourn/liste.php',
		'/adherent/list.php?mainmenu=members',
		'/product/liste.php?type=0&amp;mainmenu=products',
		'/product/liste.php?type=1&amp;mainmenu=products',
		'/comm/propal.php?mainmenu=commercial',
		'/lead/liste.php',
		'/commande/liste.php?mainmenu=commercial',
		'/compta/facture.php?mainmenu=accountancy',
		'/contrat/liste.php');
// Translation lang files
$langfile = array("bills",
		"prospects",
		"prospects",
		"suppliers",
		"members",
		"products",
		"produts",
		"propal",
		"lead@lead",
		"orders",
		"bills",
		"Contracts");


// Loop and displays each line of table
foreach ($keys as $key => $val) {
        if ($conditions[$key]) {
            $classe = $classes[$key];
// Search in cache if load_state_board is already realized
if (!isset($boardloaded[$classe]) || !is_object($boardloaded[$classe])) {
                dol_include_once($includes[$key]);

$board = new $classe($db);
$board->load_state_board($user);
$boardloaded[$classe] = $board;
}
else
	$board = $boardloaded[$classe];

$var = !$var;
if ($langfile[$key])
	$langs->load($langfile[$key]);
$title = $langs->trans($titres[$key]);
print '<tr ' . $bc[$var] . '><td width="16"><a href="' . dol_buildpath($links[$key], 1) . '">' . img_object($title, $icons[$key]) . '</a></td>';
print '<td>' . $title . '</td>';
print '<td align="right"><a href="' . dol_buildpath($links[$key], 1) . '">' . $board->nb[$val] . '</a></td>';
print '</tr>';
}
}

$object = new stdClass();
$parameters = array();
$action = '';
$reshook = $hookmanager->executeHooks('addStatisticLine', $parameters, $object, $action); // Note that $action and $object may have been modified by some hooks

print '</table>';
print end_box();
}*/

/*
 * Show boxes
*/

//print '<div class="twelve-columns">';
//FormOther::printBoxesArea($user, "0");
//print '</div></div>';
/*
 * Show security warnings
*/

// Security warning repertoire install existe (si utilisateur admin)
if ($user->admin && empty($conf->global->MAIN_REMOVE_INSTALL_WARNING)) {
    $message = '';

    // Check if install lock file is present
    $lockfile = DOL_DATA_ROOT . '/install.lock';
    if (!empty($lockfile) && !file_exists($lockfile) && is_dir(DOL_DOCUMENT_ROOT . "/install")) {
        $langs->load("errors");
        //if (! empty($message)) $message.='<br>';
        $message.=info_admin($langs->trans("WarningLockFileDoesNotExists", DOL_DATA_ROOT) . ' ' . $langs->trans("WarningUntilDirRemoved", DOL_DOCUMENT_ROOT . "/install"));
    }

    // Conf files must be in read only mode
    if (is_writable($conffile)) {
        $langs->load("errors");
        //$langs->load("other");
        //if (! empty($message)) $message.='<br>';
        $message.=info_admin($langs->transnoentities("WarningConfFileMustBeReadOnly") . ' ' . $langs->trans("WarningUntilDirRemoved", DOL_DOCUMENT_ROOT . "/install"));
    }

    if ($message) {
        print '</br><div class="row">';
        print '<div class="twelve column">';
        print $message;
        print '</div>';
        print '</div>';
        //$message.='<br>';
        //print info_admin($langs->trans("WarningUntilDirRemoved",DOL_DOCUMENT_ROOT."/install"));
    }
}

print '</div></div>';
?>
<!-- Charts library -->
<script type="text/javascript">
$(document).ready(function() {
	(function($){ // encapsulate jQuery

        $(function() {
            var seriesOptions = [],
            yAxisOptions = [],
            seriesCounter = 0,
            names = ['MSFT', 'AAPL', 'GOOG'],
            colors = Highcharts.getOptions().colors;

            $.each(names, function(i, name) {
                $.getJSON('<?php echo DOL_URL_ROOT;?>/core/ajax/listgraphexample.php?filename='+ name.toLowerCase() +'-c.json&callback=?',	function(data) {
                    seriesOptions[i] = {
                        name: name,
                        data: data
                    };

                    // As we're loading the data asynchronously, we don't know what order it will arrive. So
                    // we keep a counter and create the chart when all the data is loaded.
                    seriesCounter++;

                    if (seriesCounter == names.length) {
                        createChart();
                    }
                })
				.error(function() {log.console;});
            });



            // create the chart when all data is loaded
            function createChart() {

                chart = new Highcharts.StockChart({
                    chart: {
                        renderTo: 'demo-chart'
                    },
                    navigator : {
                        enabled : true
                    },
                    rangeSelector: {
                        selected: 4
                    },

                    yAxis: {
                        labels: {
                            formatter: function() {
                                return (this.value > 0 ? '+' : '') + this.value + '%';
                            }
                        },
                        plotLines: [{
                                value: 0,
                                width: 2,
                                color: 'silver'
                            }]
                    },

                    plotOptions: {
                        series: {
                            compare: 'percent'
                        }
                    },

                    tooltip: {
                        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.change}%)<br/>',
                        valueDecimals: 2
                    },

                    series: seriesOptions
                });
            }

        });
    })(jQuery);
});
</script>

<?php
llxFooter();
/* ?>
 <script>
$('#demo-chart').onresize(function () {
  chart.setSize(document.getElementById("demo-chart").offsetWidth,300);
		});
</script>
<?php */
?>
