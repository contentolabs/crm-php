<?php
/* Copyright (C) 2012	Regis Houssin	<regis.houssin@capnetworks.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$compta = array(
		'CHARSET' => 'UTF-8',
		'Accountancy' => '会计',
		'AccountancyCard' => '会计证',
		'Treasury' => '金库',
		'MenuFinancial' => '金融',
		'TaxModuleSetupToModifyRules' => '前往<a href="%s">模块设置</a>修改计算规则',
		'OptionMode' => '期权的会计',
		'OptionModeTrue' => '股权投入产出',
		'OptionModeVirtual' => '期权学分，转帐',
		'OptionModeTrueDesc' => '在这种情况下，营业额计算超过付款（付款日期）。 \ n此这些数字的有效性是有保证的只有当簿记审议通过输入/通过发票上的帐目输出。',
		'OptionModeVirtualDesc' => '在这种情况下，营业额计算超过发票（验证的日期）。当这些发票是因为，不论是否已支付或没有，他们在输出中列出的营业额。',
		'FeatureIsSupportedInInOutModeOnly' => '功能只在信用额，债务提供会计模式（见会计模块的配置）',
		'VATReportBuildWithOptionDefinedInModule' => '这里显示的数额计算使用由税务模块设置定义的规则。',
		'Param' => '格局',
		'RemainingAmountPayment' => '付款金额其余：',
		'AmountToBeCharged' => '支付的总金额：',
		'AccountsGeneral' => '帐目',
		'Account' => '帐户',
		'Accounts' => '帐目',
		'Accountparent' => 'Account parent',
		'Accountsparent' => 'Accounts parent',
		'BillsForSuppliers' => '条例草案对供应商',
		'Income' => '收入',
		'Outcome' => '费用',
		'ReportInOut' => '收入/支出',
		'ReportTurnover' => '营业额',
		'PaymentsNotLinkedToInvoice' => '付款不链接到任何发票，所以无法与任何第三方',
		'PaymentsNotLinkedToUser' => '付款不链接到任何用户',
		'Profit' => '利润',
		'Balance' => '平衡',
		'Debit' => '借方',
		'Credit' => '信用',
		'Withdrawal' => '提款',
		'Withdrawals' => '提款',
		'AmountHTVATRealReceived' => '净收',
		'AmountHTVATRealPaid' => '净支付',
		'VATToPay' => '增值税销售',
		'VATReceived' => '收到的增值税',
		'VATToCollect' => '购买增值税',
		'VATSummary' => '增值税平衡',
		'LT2SummaryES' => 'IRPF平衡',
		'VATPaid' => '支付的增值税',
		'LT2PaidES' => 'IRPF通知',
		'LT2CustomerES' => 'IRPF销售',
		'LT2SupplierES' => 'IRPF采购',
		'VATCollected' => '增值税征收',
		'ToPay' => '为了支付',
		'ToGet' => '取回',
		'TaxAndDividendsArea' => '税收，社会贡献和股息地区',
		'SocialContribution' => '社会贡献',
		'SocialContributions' => '社会贡献',
		'MenuTaxAndDividends' => '税和股息',
		'MenuSocialContributions' => '社会贡献',
		'MenuNewSocialContribution' => '新的贡献',
		'NewSocialContribution' => '新的社会贡献',
		'ContributionsToPay' => '缴纳会费',
		'AccountancyTreasuryArea' => '会计/库务区',
		'AccountancySetup' => '会计设置',
		'NewPayment' => '新的支付',
		'Payments' => '付款',
		'PaymentCustomerInvoice' => '客户付款发票',
		'PaymentSupplierInvoice' => '供应商发票付款',
		'PaymentSocialContribution' => '社会贡献付款',
		'PaymentVat' => '增值税纳税',
		'ListPayment' => '金名单',
		'ListOfPayments' => '金名单',
		'ListOfCustomerPayments' => '客户付款名单',
		'ListOfSupplierPayments' => '供应商付款的名单',
		'DatePayment' => '付款日期',
		'NewVATPayment' => '新的增值税纳税',
		'newLT2PaymentES' => '新IRPF付款',
		'LT2PaymentES' => 'IRPF付款',
		'LT2PaymentsES' => 'IRPF付款',
		'VATPayment' => '增值税纳税',
		'VATPayments' => '增值税付款',
		'SocialContributionsPayments' => '社会捐助金',
		'ShowVatPayment' => '显示增值税纳税',
		'TotalToPay' => '共支付',
		'TotalVATReceived' => '共收到增值税',
		'CustomerAccountancyCode' => '客户会计代码',
		'SupplierAccountancyCode' => '供应商会计代码',
		'AlreadyPaid' => '已支付',
		'AccountNumberShort' => '帐号',
		'AccountNumber' => '帐号',
		'NewAccount' => '新帐户',
		'SalesTurnover' => '销售营业额',
		'ByThirdParties' => '布第三者',
		'ByUserAuthorOfInvoice' => '笔者按发票',
		'AccountancyExport' => '会计出口',
		'ErrorWrongAccountancyCodeForCompany' => '坏客户对会计守则在％',
		'SuppliersProductsSellSalesTurnover' => '通过对供应商的产品销售产生营业额。',
		'CheckReceipt' => '支票存款',
		'CheckReceiptShort' => '支票存款',
		'NewCheckReceipt' => '新优惠',
		'NewCheckDeposit' => '新的支票存款',
		'NewCheckDepositOn' => '创建于账户上的存款收据：％s的',
		'NoWaitingChecks' => '没有支票存款等。',
		'DateChequeReceived' => '检查接收输入日期',
		'NbOfCheques' => '铌检查',
		'PaySocialContribution' => '支付的社会贡献',
		'ConfirmPaySocialContribution' => '你确定要这样归类为社会付出的贡献？',
		'DeleteSocialContribution' => '删除的社会贡献',
		'ConfirmDeleteSocialContribution' => '你确定要删除这个社会的贡献？',
		'ExportDataset_tax_1' => '社会捐款和付款',
		'AnnualSummaryDueDebtMode' => '收入和支出的平衡，年度总结，模式<b>％sClaims，据说承诺债务占％。</b>',
		'AnnualSummaryInputOutputMode' => '收入和支出的平衡，年度总结，模式<b>％sRevenues - Expensens％据说现金会计</b> 。',
		'AnnualByCompaniesDueDebtMode' => '平衡各方的收入和开支的三分之一，详细，模式<b>％sClaims，据说承诺债务占％。</b>',
		'AnnualByCompaniesInputOutputMode' => '平衡各方的收入和开支的三分之一，详细，模式<b>％sRevenues头奖％据说现金会计</b> 。',
		'SeeReportInInputOutputMode' => '见报告<b>％sIncomes头奖％据说占</b>实际支付的<b>现金</b>计算所取得的',
		'SeeReportInDueDebtMode' => '见报告<b>％sClaims -％s的债务承担会计</b>说发票计算的颁布',
		'RulesResultDue' => '- 应收显示包含所有税金<br> - 它包括尚未发票，费用和增值税是否缴纳或者未。 <br> - 这是对发票和增值税，并在到期日确认为费用的日期为基础。',
		'RulesResultInOut' => '- 应收显示包含所有税金<br> - 它包括发票，费用和增值税的实际付款。 <br> - 这是对发票的付款日期的，费用心钠素增值税。 <br>',
		'RulesCADue' => '- 它包括客户端的他们是否缴纳或者未到期的发票。 <br> - 正是在这些发票日期计算验证。 <br>',
		'RulesCAIn' => '- 它包括所有从客户收到发票有效付款。 <br> - 这是对这些发票的付款日期为基础<br>',
		'DepositsAreNotIncluded' => '- 存款发票，也不包括',
		'DepositsAreIncluded' => '- 存款发票',
		'LT2ReportByCustomersInInputOutputModeES' => '报告由第三方IRPF',
		'VATReportByCustomersInInputOutputMode' => '报告由客户收取的增值税和支付（增值税收据）',
		'VATReportByCustomersInDueDebtMode' => '报告由客户收取的增值税和支付（增值税率）',
		'VATReportByQuartersInInputOutputMode' => '报告所收集的增值税率和支付（增值税收据）',
		'VATReportByQuartersInDueDebtMode' => '报告所收集的增值税率和支付（增值税率）',
		'SeeVATReportInInputOutputMode' => '见报告<b>％sVAT装箱％S</b>的标准计算',
		'SeeVATReportInDueDebtMode' => '见报告<b>流量％％sVAT S上</b>的流量计算与一选项',
		'RulesVATInServices' => '- 对于服务，该报告包括实际收到或发出的付款日期的基础上规定的增值税。 <br> - 对于重大资产，它包括增值税专用发票发票日期的基础上。',
		'RulesVATInProducts' => '- 对于重大资产，它包括增值税专用发票发票日期的基础上。',
		'RulesVATDueServices' => '- 对于服务，该报告包括增值税专用发票，根据发票日期到期，缴纳或者未。',
		'RulesVATDueProducts' => '- 对于重大资产，它包括增值税专用发票，根据发票日期。',
		'OptionVatInfoModuleComptabilite' => '注：对于实物资产，它应该使用的交货日期将更加公平。',
		'PercentOfInvoice' => '％％/发票',
		'NotUsedForGoods' => '未使用的货物',
		'ProposalStats' => '统计数据的建议',
		'OrderStats' => '订单统计',
		'InvoiceStats' => '法案的统计数字',
		'Dispatch' => '调度',
		'Dispatched' => '调度',
		'ToDispatch' => '派遣',
		'ThirdPartyMustBeEditAsCustomer' => '第三方必须定义为顾客',
		'SellsJournal' => '销售杂志',
		'PurchasesJournal' => '购买杂志',
		'DescSellsJournal' => '销售杂志',
		'DescPurchasesJournal' => '购买杂志',
		'InvoiceRef' => '发票编号。',
		'CodeNotDef' => '没有定义',
		'AddRemind' => '调度可用金额',
		'RemainToDivide' => '保持派遣：',
		'WarningDepositsNotIncluded' => '存款发票不包括在此版本与本会计模块。',
		'DatePaymentTermCantBeLowerThanObjectDate' => 'Payment term date can\'t be lower than object date.',
		'Pcg_version' => 'Pcg version',
		'Pcg_type' => 'Pcg type',
		'Pcg_subtype' => 'Pcg subtype',
		'Withdrawl' => 'Prélèvement',
		'Withdrawls' => 'Prélèvements',
		'ToGetBack' => 'A récupérer',
		'Journaux' => 'Journaux',
		'Piece' => 'Piece compta',
		'JournalNum' => 'Journal',
		'COMPTA_JOURNAL_SELL' => 'Numéro comptable du Journal des Achats',
		'COMPTA_JOURNAL_BUY' => 'Numéro comptable du Journal des Ventes',
		'COMPTA_PRODUCT_BUY_ACCOUNT' => 'Compte comptable par défaut pour produits achetés (si non défini sur fiche produit)',
		'COMPTA_PRODUCT_SOLD_ACCOUNT' => 'Compte comptable par défaut pour produits vendus (si non défini sur fiche produit)',
		'COMPTA_SERVICE_BUY_ACCOUNT' => 'Compte comptable par défaut pour services achetés (si non défini sur fiche service)',
		'COMPTA_SERVICE_SOLD_ACCOUNT' => 'Compte comptable par défaut pour services vendus (si non défini sur fiche service)',
		'COMPTA_VAT_ACCOUNT' => 'Compte comptable par défaut pour TVA (si non défini dans dictionnaire "Taux de TVA")',
		'COMPTA_ACCOUNT_CUSTOMER' => 'Compte comptable client par défaut (si non défini sur fiche tiers)',
		'COMPTA_ACCOUNT_SUPPLIER' => 'Compte comptable fournisseur par défaut (si non défini sur fiche tiers)',
);
?>