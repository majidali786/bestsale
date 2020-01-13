<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
////----------login--------/////
$route['login']['post']='login/userlogin';

/// Edit Section
$route['edit/origing']='edit/origing';
$route['edit/subProduct']='edit/subProduct';
$route['edit/sub-party']='edit/subparty';
$route['edit/party']='edit/party';
$route['edit/account-group']='edit/accountGroup';
$route['edit/account-group/(:any)']='edit/accountGroup/$1';
$route['edit/user-type']='edit/userType';
$route['edit/user-type/(:any)']='edit/userType/$1';
$route['edit/main-group']='edit/mainGroup';
$route['edit/main-group/(:any)']='edit/mainGroup/$1';

$route['edit/sub-group']='edit/subGroup';
$route['edit/sub-group/(:any)']='edit/subGroup/$1';

$route['edit/unit']='edit/unit';
$route['edit/unit/(:any)']='edit/unit/$1';

$route['edit/bank']='edit/bank';
$route['edit/bank/(:any)']='edit/bank/$1';

$route['edit/sale-man']='edit/saleman';
$route['edit/sale-man/(:any)']='edit/saleman/$1';

$route['edit/pricelist']='edit/pricelist';
$route['edit/pricelist/(:any)']='edit/pricelist/$1';

$route['edit/outer-dia']='edit/outerDia';
$route['edit/outer-dia/(:any)']='edit/outerDia/$1';
$route['edit/inner-dia']='edit/innerDia';
$route['edit/inner-dia/(:any)']='edit/innerDia/$1';
$route['edit/cr-hr-type']='edit/HRType';
$route['edit/cr-hr-type/(:any)']='edit/HRType/$1';

$route['change-password']='edit/changePassword';
$route['change-password/(:any)']='edit/changePassword/$1';
////// chart of account
$route['edit/chart-of-account']='ChartOfAccount/index';
$route['edit/chart-of-account/(:any)']='ChartOfAccount/index/$1';
$route['chart-of-account-load-level/(:any)']['get']='ChartOfAccount/loadAccountLevel/$1';
$route['chart-of-account-add-level/(:any)']['get']='ChartOfAccount/getAccountLevel/$1';
$route['chart-of-account-add-level/(:any)']['post']='ChartOfAccount/addAccountLevel/$1';
$route['chart-of-account-edit-level/(:any)']['get']='ChartOfAccount/getAccountLevelEdit/$1';
$route['chart-of-account-edit-level/(:any)']['post']='ChartOfAccount/editAccountLevel/$1';
$route['chart-of-account-delete-level/(:any)']['post']='ChartOfAccount/deleteAccountLevel/$1';
$route['chart-of-account-get-code']['get']='ChartOfAccount/getAccountCode/$1';
$route['chart-of-account-details/party']['get']='ChartOfAccount/getParty/$1';
$route['chart-of-account-details/party']['post']='ChartOfAccount/saveParty/$1';
$route['chart-of-account-details/employee']['get']='ChartOfAccount/getEmployee/$1';
$route['chart-of-account-details/employee']['post']='ChartOfAccount/saveEmployee/$1';
$route['chart-of-account-details/atype']['get']='ChartOfAccount/getAcountsAtype/$1';
$route['chart-of-account-details/account']['get']='ChartOfAccount/getAcountsDetail/$1';


///// financial start
$route['financial/cash-reciept']='financial/cashReciept';
$route['financial/cash-reciept/(:any)']='financial/cashReciept/$1';
$route['financial/cash-reciept/(:any)/(:any)']='financial/cashReciept/$1';

$route['financial/cash-payment']='financial/cashPayment';
$route['financial/cash-payment/(:any)']='financial/cashPayment/$1';
$route['financial/cash-payment/(:any)/(:any)']='financial/cashPayment/$1';

$route['financial/bank-reciept']='financial/bankReciept';
$route['financial/bank-reciept/(:any)']='financial/bankReciept/$1';
$route['financial/bank-reciept/(:any)/(:any)']='financial/bankReciept/$1';

$route['financial/bank-payment']='financial/bankPayment';
$route['financial/bank-payment/(:any)']='financial/bankPayment/$1';
$route['financial/bank-payment/(:any)/(:any)']='financial/bankPayment/$1';

$route['financial/opening-journal']='financial/opJournal';
$route['financial/opening-journal/(:any)']='financial/opJournal/$1';
$route['financial/opening-journal/(:any)/(:any)']='financial/opJournal/$1';

$route['financial/china-opening']='financial/cjournal';
$route['financial/china-opening/(:any)']='financial/cjournal/$1';
$route['financial/china-opening/(:any)/(:any)']='financial/cjournal/$1';

$route['financial/cheque-reciept']='financial/chqReciept';
$route['financial/cheque-reciept/(:any)']='financial/chqReciept/$1';
$route['financial/cheque-reciept/(:any)/(:any)']='financial/chqReciept/$1';

$route['financial/cheque-transfer']='financial/chqTransfer';
$route['financial/cheque-transfer/(:any)']='financial/chqTransfer/$1';
$route['financial/cheque-transfer/(:any)/(:any)']='financial/chqTransfer/$1';

$route['edit/account-group-activity']='financial/accountGroup';
$route['edit/account-group-activity/(:any)']='financial/accountGroup/$1';
$route['edit/account-group-activity/(:any)/(:any)']='financial/accountGroup/$1';

$route['financial/cheque-book']='financial/chqBook';
$route['financial/cheque-book/(:any)']='financial/chqBook/$1';
$route['financial/cheque-book/(:any)/(:any)']='financial/chqBook/$1';

$route['financial/cheque-return']='financial/chqReturn';
$route['financial/cheque-return/(:any)']='financial/chqReturn/$1';
$route['financial/cheque-return/(:any)/(:any)']='financial/chqReturn/$1';

$route['financial/discount']='sales/discount';
$route['financial/discount/(:any)']='sales/discount/$1';
$route['financial/discount/(:any)/(:any)']='sales/discount/$1';

$route['financial/scash-payment']='financial/scashPayment';
$route['financial/scash-payment/(:any)']='financial/scashPayment/$1';
$route['financial/scash-payment/(:any)/(:any)']='financial/scashPayment/$1';

///// financial end 

///// Sales start

$route['sales/sale']='sales/sale';
$route['sales/sale/(:any)']='sales/sale/$1';
$route['sales/sale/(:any)/(:any)']='sales/sale/$1';



$route['sales/sale-voucher']='sales/saleVoucher';
$route['sales/sale-voucher/(:any)']='sales/saleVoucher/$1';
$route['sales/sale-voucher/(:any)/(:any)']='sales/saleVoucher/$1';


$route['sales/sale-invoice']='sales/saleInvoice';
$route['sales/sale-invoice/(:any)']='sales/saleInvoice/$1';
$route['sales/sale-invoice/(:any)/(:any)']='sales/saleInvoice/$1';



$route['sales/customer-demand-order']='sales/customerDemandOrder';
$route['sales/customer-demand-order/(:any)']='sales/customerDemandOrder/$1';
$route['sales/customer-demand-order/(:any)/(:any)']='sales/customerDemandOrder/$1';

$route['sales/sale-order']='sales/saleOrder';
$route['sales/sale-order/(:any)']='sales/saleOrder/$1';
$route['sales/sale-order/(:any)/(:any)']='sales/saleOrder/$1';

$route['sales/limit-adjustment']='sales/limitAdjustment';
$route['sales/limit-adjustment/(:any)']='sales/limitAdjustment/$1';
$route['sales/limit-adjustment/(:any)/(:any)']='sales/limitAdjustment/$1';

$route['sales/delivery-challan']='sales/deliveryChallan';
$route['sales/delivery-challan/(:any)']='sales/deliveryChallan/$1';
$route['sales/delivery-challan/(:any)/(:any)']='sales/deliveryChallan/$1';

$route['sales/sale-return']='sales/saleReturn';
$route['sales/sale-return/(:any)']='sales/saleReturn/$1';
$route['sales/sale-return/(:any)/(:any)']='sales/saleReturn/$1';

$route['sales/book-issue-note']='sales/bookIssueNote';
$route['sales/book-issue-note/(:any)']='sales/bookIssueNote/$1';
$route['sales/book-issue-note/(:any)/(:any)']='sales/bookIssueNote/$1';

$route['sales/sale-adjustment']='sales/saleadj';
$route['sales/sale-adjustment/(:any)']='sales/saleadj/$1';
$route['sales/sale-adjustment/(:any)/(:any)']='sales/saleadj/$1';

///// Purchase start

$route['purchase/purchase-order']='purchase/purchaseOrder';
$route['purchase/purchase-order/(:any)']='purchase/purchaseOrder/$1';
$route['purchase/purchase-order/(:any)/(:any)']='purchase/purchaseOrder/$1';

$route['purchase/transfer-order']='purchase/transfer';
$route['purchase/transfer-order/(:any)']='purchase/transfer/$1';
$route['purchase/transfer-order/(:any)/(:any)']='purchase/transfer/$1';


$route['purchase/purchase-demand']='purchase/purchasedemand';
$route['purchase/purchase-demand/(:any)']='purchase/purchasedemand/$1';
$route['purchase/purchase-demand/(:any)/(:any)']='purchase/purchasedemand/$1';


$route['purchase/purchase-voucher']='purchase/purchaseVoucher';
$route['purchase/purchase-voucher/(:any)']='purchase/purchaseVoucher/$1';
$route['purchase/purchase-voucher/(:any)/(:any)']='purchase/purchaseVoucher/$1';

$route['purchase/purchase-return']='purchase/purchaseReturn';
$route['purchase/purchase-return/(:any)']='purchase/purchaseReturn/$1';
$route['purchase/purchase-return/(:any)/(:any)']='purchase/purchaseReturn/$1';

$route['purchase/purchase']='purchase/purchase';
$route['purchase/purchase/(:any)']='purchase/purchase/$1';
$route['purchase/purchase/(:any)/(:any)']='purchase/purchase/$1';


///// inventory start
$route['inventory/stock-transfer']='inventory/stockTransfer';
$route['inventory/stock-transfer/(:any)']='inventory/stockTransfer/$1';
$route['inventory/stock-transfer/(:any)/(:any)']='inventory/stockTransfer/$1';
$route['inventory/opening-stock']='inventory/openingStock';
$route['inventory/opening-stock/(:any)']='inventory/openingStock/$1';
$route['inventory/opening-stock/(:any)/(:any)']='inventory/openingStock/$1';
$route['inventory/balance']='inventory/balance/$1';
$route['inventory/balance/(:any)']='inventory/balance/$1';
$route['inventory/amount']='inventory/amount/$1';
$route['inventory/amount/(:any)']='inventory/amount/$1';
$route['inventory/ledger']='inventory/ledger/$1';
$route['inventory/ledger/(:any)']='inventory/ledger/$1';
$route['inventory/movement']='inventory/movement/$1';
$route['inventory/movement/(:any)']='inventory/movement/$1';
$route['inventory/stocktransfer']='inventory/StockTransferlist/$1';
$route['inventory/stocktransfer/(:any)']='inventory/StockTransferlist/$1';


//// Data ////
$route['data/branch-change']['post']='data/branchChange/$1';
$route['data/print']['post']='data/printOuts/$1';

$route['data/party-limitadj']='data/limitAdj';
$route['data/party-limitadj/(:any)']='data/limitAdj/$1';

$route['data/party-data/(:any)']='data/partyData/$1';
$route['data/party-data/(:any)/(:any)']='data/partyData/$1';
$route['data/party-data/(:any)/(:any)/(:any)']='data/partyData/$1';

$route['data/sparty-data']='data/spartyData';
$route['data/sparty-data/(:any)']='data/spartyData/$1';

$route['data/reference-cheque']='data/referenceCheque/$1';
$route['data/reference-cheque-invoices']='data/referenceChequeInvoices/$1';
$route['data/purchase-invoices']='data/purchaseInvoices/$1';
$route['data/order-invoices']='data/orderInvoices/$1';
$route['data/sale-invoices']='data/saleInvoices/$1';
$route['data/memo-invoices']='data/memoInvoices/$1';
$route['data/clear-book-no']='data/clearBookNo/$1';
$route['data/check-branch']='data/checkBranch/$1';
$route['data/voucher-details']='data/voucherDetails/$1';
$route['data/current-stock']='data/currentStock/$1';
$route['data/getinvoices']='data/SaleInvc/$1';
$route['data/getrate']='data/ProductRate/$1';
$route['data/getrate1']='data/ProductRate1/$1';
$route['data/getunit']='data/ProductUnit/$1';
$route['data/getdesign']='data/Productdesign/$1';
$route['data/getdiscount']='data/ProductDiscount/$1';
$route['data/get-stock']='data/getStock/$1';

$route['data/chq-book']='data/chqbook/$1';
$route['data/chq-book-chqs']='data/chqbookChq/$1';
$route['data/chq-book-chqs-cancel']='data/chqbookChqCancel/$1';
$route['data/chq-book-chqs-cancel-undo']='data/chqbookChqCancelUndo/$1';
$route['data/pending-cheque']='data/pendingChq/$1';
$route['data/bookno-closed']='data/booknoClosed/$1';
$route['data/bookno-closed-undo']='data/booknoClosedReuse/$1';
$route['data/clear-book-no-memo']='data/clearBookNoMemo/$1';
$route['data/bookno-memo-closed']='data/booknoMemoClosed/$1';
$route['data/bookno-memo-closed-undo']='data/booknoMemoClosedReuse/$1';
$route['data/sale-voucher-details']='data/saleVoucherDetails/$1';

$route['data/get_max_acode']='data/get_max_acode';

//// UserRights ////
$route['user-rights']='UserRights/index/$1';
$route['user-rights/menu-rights']['get']='UserRights/getMenuRights/$1';
$route['user-rights/menu-rights/(:any)']['get']='UserRights/getMenuRights/$1';
$route['user-rights/menu-rights']['post']='UserRights/saveMenuRights/$1';

$route['user-rights/voucher-rights']['get']='UserRights/getVoucherRights/$1';
$route['user-rights/voucher-rights/(:any)']['get']='UserRights/getVoucherRights/$1';
$route['user-rights/voucher-rights']['post']='UserRights/saveVoucherRights/$1';

$route['user-rights/other-rights']['get']='UserRights/getOtherRights/$1';
$route['user-rights/other-rights/(:any)']['get']='UserRights/getOtherRights/$1';
$route['user-rights/other-rights']['post']='UserRights/saveOtherRights/$1';


///// customer reports
$route['customer-reports/balance']='CustomerReports/balance/$1';
$route['customer-reports/balance/(:any)']='CustomerReports/balance/$1';
$route['customer-reports/ledger']='CustomerReports/ledger/$1';
$route['customer-reports/ledger/(:any)']='CustomerReports/ledger/$1';
$route['customer-reports/ledger-with-cheques']='CustomerReports/ledgerChq/$1';
$route['customer-reports/ledger-with-cheques/(:any)']='CustomerReports/ledgerChq/$1';
$route['customer-reports/cheque-details']='CustomerReports/chqDetail/$1';
$route['customer-reports/cheque-details/(:any)']='CustomerReports/chqDetail/$1';
$route['customer-reports/invoice-details']='CustomerReports/invoiceDetail/$1';
$route['customer-reports/invoice-details/(:any)']='CustomerReports/invoiceDetail/$1';
$route['customer-reports/invoice-cash-details']='CustomerReports/invoiceCashDetail/$1';
$route['customer-reports/invoice-cash-details/(:any)']='CustomerReports/invoiceCashDetail/$1';
$route['customer-reports/ledger-all']='CustomerReports/ledgerAll/$1';
$route['customer-reports/ledger-all/(:any)']='CustomerReports/ledgerAll/$1';
$route['customer-reports/ledger-all-cheque']='CustomerReports/ledgerAllChqs/$1';
$route['customer-reports/ledger-all-cheque/(:any)']='CustomerReports/ledgerAllChqs/$1';
$route['customer-reports/aging']='CustomerReports/aging/$1';
$route['customer-reports/aging/(:any)']='CustomerReports/aging/$1';
$route['customer-reports/aging-previous']='CustomerReports/agingPrevious/$1';
$route['customer-reports/aging-previous/(:any)']='CustomerReports/agingPrevious/$1';
$route['customer-reports/aging-all']='CustomerReports/agingAll/$1';
$route['customer-reports/aging-all/(:any)']='CustomerReports/agingAll/$1';
$route['customer-reports/salesman-aging']='CustomerReports/salesmanAging/$1';
$route['customer-reports/salesman-aging/(:any)']='CustomerReports/salesmanAging/$1';
$route['customer-reports/aging-all-previous']='CustomerReports/agingAllPrevious/$1';
$route['customer-reports/aging-all-previous/(:any)']='CustomerReports/agingAllPrevious/$1';
$route['customer-reports/sperson-wise-recovery-with-cheques']='CustomerReports/spersonRecoveryChq/$1';
$route['customer-reports/sperson-wise-recovery-with-cheques/(:any)']='CustomerReports/spersonRecoveryChq/$1';
$route['customer-reports/sperson-wise-recovery-with-cheques-graph']='CustomerReports/spersonRecoveryChqGraph/$1';
$route['customer-reports/sperson-wise-recovery-with-cheques-graph/(:any)']='CustomerReports/spersonRecoveryChqGraph/$1';
$route['customer-reports/balance-comparison']='CustomerReports/balanceComparison/$1';
$route['customer-reports/balance-comparison/(:any)']='CustomerReports/balanceComparison/$1';
$route['customer-reports/listing']='CustomerReports/listing/$1';
$route['customer-reports/listing/(:any)']='CustomerReports/listing/$1';
$route['customer-reports/invoice-summary']='CustomerReports/invoiceSummary/$1';
$route['customer-reports/invoice-summary/(:any)']='CustomerReports/invoiceSummary/$1';

///// Financial reports
$route['financial-reports/activity']='FinancialReports/ledger/$1';
$route['financial-reports/activity/(:any)']='FinancialReports/ledger/$1';
$route['financial-reports/employee']='FinancialReports/Eledger/$1';
$route['financial-reports/employee/(:any)']='FinancialReports/Eledger/$1';

$route['financial-reports/expense']='FinancialReports/Expense/$1';
$route['financial-reports/expense/(:any)']='FinancialReports/Expense/$1';

$route['financial-reports/trial']='FinancialReports/trial/$1';
$route['financial-reports/trial/(:any)']='FinancialReports/trial/$1';
$route['financial-reports/trial-group']='FinancialReports/trialGroup/$1';
$route['financial-reports/trial-group/(:any)']='FinancialReports/trialGroup/$1';
$route['financial-reports/cash-book']='FinancialReports/cashBook/$1';
$route['financial-reports/cash-book/(:any)']='FinancialReports/cashBook/$1';
$route['financial-reports/cash-bank']='FinancialReports/cashBank/$1';
$route['financial-reports/cash-bank/(:any)']='FinancialReports/cashBank/$1';

$route['financial-reports/trial-simple']='FinancialReports/trialSimple/$1';
$route['financial-reports/trial-simple/(:any)']='FinancialReports/trialSimple/$1';
$route['financial-reports/user-log']='FinancialReports/userLog/$1';
$route['financial-reports/user-log/(:any)']='FinancialReports/userLog/$1';
$route['financial-reports/daily-log']='FinancialReports/dailyLog/$1';
$route['financial-reports/daily-log/(:any)']='FinancialReports/dailyLog/$1';
$route['financial-reports/chqs-in-hand']='FinancialReports/chqsInHand/$1';
$route['financial-reports/chqs-in-hand/(:any)']='FinancialReports/chqsInHand/$1';
$route['financial-reports/bls']='FinancialReports/bls/$1';
$route['financial-reports/bls/(:any)']='FinancialReports/bls/$1';
$route['financial-reports/pls']='FinancialReports/pls/$1';
$route['financial-reports/pls/(:any)']='FinancialReports/pls/$1';
$route['financial-reports/cash-flow']='FinancialReports/cashflow/$1';
$route['financial-reports/cash-flow/(:any)']='FinancialReports/cashflow/$1';
///// supplier reports
$route['supplier-reports/balance']='SupplierReports/balance/$1';
$route['supplier-reports/balance/(:any)']='SupplierReports/balance/$1';
$route['supplier-reports/ledger']='SupplierReports/ledger/$1';
$route['supplier-reports/ledger/(:any)']='SupplierReports/ledger/$1';
$route['supplier-reports/sbalance']='SupplierReports/sbalance/$1';
$route['supplier-reports/sbalance/(:any)']='SupplierReports/sbalance/$1';

$route['supplier-reports/sledger']='SupplierReports/sledger/$1';
$route['supplier-reports/sledger/(:any)']='SupplierReports/sledger/$1';
$route['supplier-reports/aging']='SupplierReports/aging/$1';
$route['supplier-reports/aging/(:any)']='SupplierReports/aging/$1';
$route['supplier-reports/aging-all']='SupplierReports/agingAll/$1';
$route['supplier-reports/aging-all/(:any)']='SupplierReports/agingAll/$1';
$route['supplier-reports/cheque-details/(:any)']='SupplierReports/chqDetail/$1';
$route['supplier-reports/invoice-details']='SupplierReports/invoiceDetail/$1';
$route['supplier-reports/invoice-details/(:any)']='SupplierReports/invoiceDetail/$1';
$route['supplier-reports/invoice-summary']='SupplierReports/invoiceSummary/$1';
$route['supplier-reports/invoice-summary/(:any)']='SupplierReports/invoiceSummary/$1';

////// Payroll 
$route['pay-roll/department']='Payroll/department/$1';
$route['pay-roll/department/(:any)']='Payroll/department/$1';
$route['pay-roll/designation']='Payroll/designation/$1';
$route['pay-roll/designation/(:any)']='Payroll/designation/$1';
$route['pay-roll/salary-information']='Payroll/salaryinfo/$1';
$route['pay-roll/salary-information/(:any)']='Payroll/salaryinfo/$1';
$route['pay-roll/salary-sheet']='Payroll/salarySheet/$1';
$route['pay-roll/salary-sheet/(:any)']='Payroll/salarySheet/$1';
$route['pay-roll/salary-sheet-daily']='Payroll/salarySheetDaily/$1';
$route['pay-roll/salary-sheet-daily/(:any)']='Payroll/salarySheetDaily/$1';
$route['pay-roll/loan-advance']='Payroll/loan';
$route['pay-roll/loan-advance/(:any)']='Payroll/loan/$1';
$route['pay-roll/loan-advance/(:any)/(:any)']='Payroll/loan/$1';
$route['pay-roll/loan-advance-payment']='Payroll/loanPayment';
$route['pay-roll/loan-advance-payment/(:any)']='Payroll/loanPayment/$1';
$route['pay-roll/loan-advance-payment/(:any)/(:any)']='Payroll/loanPayment/$1';
$route['pay-roll/salary-increment']='Payroll/salaryIncrement';
$route['pay-roll/salary-increment/(:any)']='Payroll/salaryIncrement/$1';
$route['pay-roll/salary-increment/(:any)/(:any)']='Payroll/salaryIncrement/$1';
////Payroll Report
$route['payroll-reports/loan-advance']='PayrollReports/loanAdvance/$1';
$route['payroll-reports/loan-advance/(:any)']='PayrollReports/loanAdvance/$1';
$route['payroll-reports/salary-increment']='PayrollReports/salaryIncrement/$1';
$route['payroll-reports/salary-increment/(:any)']='PayrollReports/salaryIncrement/$1';



/////// LC 
$route['lc/location']='lc/lcLocation/$1';
$route['lc/location/(:any)']='lc/lcLocation/$1';
$route['lc/bond']='lc/lcBond/$1';
$route['lc/bond/(:any)']='lc/lcBond/$1';
$route['lc/lc-information']='lc/lcInfo';
$route['lc/lc-information/(:any)']='lc/lcInfo/$1';
$route['lc/lc-information/(:any)/(:any)']='lc/lcInfo/$1';
$route['lc/lc-expense']='lc/lcExpense';
$route['lc/lc-expense/(:any)']='lc/lcExpense/$1';
$route['lc/lc-expense/(:any)/(:any)']='lc/lcExpense/$1';
$route['lc/lc-purchase']='lc/lcPurchase';
$route['lc/lc-purchase/(:any)']='lc/lcPurchase/$1';
$route['lc/lc-purchase/(:any)/(:any)']='lc/lcPurchase/$1';
$route['lc/lc-sale']='lc/lcSale';
$route['lc/lc-sale/(:any)']='lc/lcSale/$1';
$route['lc/lc-sale/(:any)/(:any)']='lc/lcSale/$1';
$route['lc/journal']='lc/journal';
$route['lc/journal/(:any)']='lc/journal/$1';
$route['lc/journal/(:any)/(:any)']='lc/journal/$1';
$route['lc/lc-stock-transfer']='lc/stockTransfer';
$route['lc/lc-stock-transfer/(:any)']='lc/stockTransfer/$1';
$route['lc/lc-stock-transfer/(:any)/(:any)']='lc/stockTransfer/$1';
//// LC Report
$route['lc-reports/stock-movement']='lcReports/stockMovement/$1';
$route['lc-reports/stock-movement/(:any)']='lcReports/stockMovement/$1';
$route['lc-reports/activity']='lcReports/ledger/$1';
$route['lc-reports/activity/(:any)']='lcReports/ledger/$1';


///// Memo (Cash/Credit)
$route['memo/memo-voucher']='memo/memoVoucher';
$route['memo/memo-voucher/(:any)']='memo/memoVoucher/$1';
$route['memo/memo-voucher/(:any)/(:any)']='memo/memoVoucher/$1';
$route['memo/memo-voucher-type']='memo/memoVoucherType/$1';
$route['memo/memo-voucher-edit-type']='memo/memoVoucherEditType/$1';

$route['memo/cash-payment-memo']='memo/cashPayment';
$route['memo/cash-payment-memo/(:any)']='memo/cashPayment/$1';
$route['memo/cash-payment-memo/(:any)/(:any)']='memo/cashPayment/$1';
$route['memo/book-issue-note']='memo/bookIssueNote';
$route['memo/book-issue-note/(:any)']='memo/bookIssueNote/$1';
$route['memo/book-issue-note/(:any)/(:any)']='memo/bookIssueNote/$1';

//// Memo Reports
$route['memo-reports/invoice-details']='MemoReports/invoiceDetail/$1';
$route['memo-reports/invoice-details/(:any)']='MemoReports/invoiceDetail/$1';


//// Store & Spare
$route['store-and-spare/demand-order']='StoreSpare/DemandOrder';
$route['store-and-spare/demand-order/(:any)']='StoreSpare/DemandOrder/$1';
$route['store-and-spare/demand-order/(:any)/(:any)']='StoreSpare/DemandOrder/$1';
$route['store-and-spare/goods-receipt-note']='StoreSpare/goodReceiptNote';
$route['store-and-spare/goods-receipt-note/(:any)']='StoreSpare/goodReceiptNote/$1';
$route['store-and-spare/goods-receipt-note/(:any)/(:any)']='StoreSpare/goodReceiptNote/$1';
$route['store-and-spare/stock-transfer']='StoreSpare/stockTransfer';
$route['store-and-spare/stock-transfer/(:any)']='StoreSpare/stockTransfer/$1';
$route['store-and-spare/stock-transfer/(:any)/(:any)']='StoreSpare/stockTransfer/$1';
$route['store-and-spare/stock-return']='StoreSpare/stockReturnNote';
$route['store-and-spare/stock-return/(:any)']='StoreSpare/stockReturnNote/$1';
$route['store-and-spare/stock-return/(:any)/(:any)']='StoreSpare/stockReturnNote/$1';
$route['store-and-spare/stock-consumption']='StoreSpare/stockConsumption';
$route['store-and-spare/stock-consumption/(:any)']='StoreSpare/stockConsumption/$1';
$route['store-and-spare/stock-consumption/(:any)/(:any)']='StoreSpare/stockConsumption/$1';
$route['store-and-spare/product']='StoreSpare/product';
$route['store-and-spare/product/(:any)']='StoreSpare/product/$1';
$route['store-and-spare/main-group']='StoreSpare/mainGroup';
$route['store-and-spare/main-group/(:any)']='StoreSpare/mainGroup/$1';
$route['store-and-spare/item-name']='StoreSpare/itemName';
$route['store-and-spare/item-name/(:any)']='StoreSpare/itemName/$1';
$route['store-and-spare/size']='StoreSpare/size';
$route['store-and-spare/size/(:any)']='StoreSpare/size/$1';
$route['store-and-spare/nature']='StoreSpare/nature';
$route['store-and-spare/nature/(:any)']='StoreSpare/nature/$1';
$route['store-and-spare/feet']='StoreSpare/feet';
$route['store-and-spare/feet/(:any)']='StoreSpare/feet/$1';
$route['store-and-spare/unit']='StoreSpare/unit';
$route['store-and-spare/unit/(:any)']='StoreSpare/unit/$1';
$route['store-and-spare/weight']='StoreSpare/weight';
$route['store-and-spare/weight/(:any)']='StoreSpare/weight/$1';
$route['store-and-spare/others-1']='StoreSpare/others1';
$route['store-and-spare/others-1/(:any)']='StoreSpare/others1/$1';
$route['store-and-spare/others-2']='StoreSpare/others2';
$route['store-and-spare/others-2/(:any)']='StoreSpare/others2/$1';
$route['store-and-spare/others-3']='StoreSpare/others3';
$route['store-and-spare/others-3/(:any)']='StoreSpare/others3/$1';
'store-and-spare/stockTransfer/$1';
$route['store-and-spare/opening-stock']='StoreSpare/openingStock';
$route['store-and-spare/opening-stock/(:any)']='StoreSpare/openingStock/$1';
$route['store-and-spare/opening-stock/(:any)/(:any)']='StoreSpare/openingStock/$1';
//// Store & Spare Report
$route['store-and-spare-reports/stock-transfer']='StoreSpareReports/stockTransfer/$1';
$route['store-and-spare-reports/stock-transfer/(:any)']='StoreSpareReports/stockTransfer/$1';
$route['store-and-spare-reports/balance']='StoreSpareReports/balance/$1';
$route['store-and-spare-reports/balance/(:any)']='StoreSpareReports/balance/$1';
$route['store-and-spare-reports/ledger']='StoreSpareReports/ledger/$1';
$route['store-and-spare-reports/ledger/(:any)']='StoreSpareReports/ledger/$1';
$route['store-and-spare-reports/movement']='StoreSpareReports/movement/$1';
$route['store-and-spare-reports/movement/(:any)']='StoreSpareReports/movement/$1';

//// Sales Report
$route['sales-reports/saleslist-report']='SalesReports/SaleList/$1';
$route['sales-reports/saleslist-report/(:any)']='SalesReports/SaleList/$1';

$route['sales-reports/salesadj-report']='SalesReports/SaleAdj/$1';
$route['sales-reports/salesadj-report/(:any)']='SalesReports/SaleAdj/$1';

$route['sales-reports/sales']='SalesReports/sales/$1';
$route['sales-reports/sales/(:any)']='SalesReports/sales/$1';
$route['sales-reports/sale-return']='SalesReports/saleReturn/$1';
$route['sales-reports/sale-return/(:any)']='SalesReports/saleReturn/$1';


//// Purchase Report
$route['purchase-reports/purchase-order']='purchaseReports/Purchaseorders/$1';
$route['purchase-reports/purchase-order/(:any)']='purchaseReports/Purchaseorders/$1';

$route['purchase-reports/purchase']='purchaseReports/purchase/$1';
$route['purchase-reports/purchase/(:any)']='purchaseReports/purchase/$1';
$route['purchase-reports/purchase-return']='purchaseReports/purchaseReturn/$1';
$route['purchase-reports/purchase-return/(:any)']='purchaseReports/purchaseReturn/$1';
//// Transfershipment Report
$route['purchase-reports/transfership-report']='purchaseReports/transfership/$1';
$route['purchase-reports/transfership-report/(:any)']='purchaseReports/transfership/$1';


$route['purchase-reports/pending-order']='purchaseReports/Pendingorders/$1';
$route['purchase-reports/pending-order/(:any)']='purchaseReports/Pendingorders/$1';
/// Notification Section
$route['notification/pending-voucher']='Notification/pendingVoucher';
$route['notification/pending-voucher/(:any)']='Notification/pendingVoucher/$1';

//// Production 
$route['production/production-karol']='production/productionKarol';
$route['production/production-karol/(:any)']='production/productionKarol/$1';
$route['production/production-karol/(:any)/(:any)']='production/productionKarol/$1';
$route['production/kalrol-raw-product']='production/KarolRaw/$1';
$route['production/production']='production/production';
$route['production/production/(:any)']='production/production/$1';
$route['production/production/(:any)/(:any)']='production/production/$1';

//// Promise 
$route['promise/promise-voucher']='promise/promiseVoucher';
$route['promise/promise-voucher/(:any)']='promise/promiseVoucher/$1';
$route['promise/promise-voucher/(:any)/(:any)']='promise/promiseVoucher/$1';
$route['load-promises']='promise/loadPromises/$1';
$route['load-promise']='promise/loadPromise/$1';
$route['promise/comment/(:any)']["post"]='promise/comment/$1';

/// Promise Reports
$route['customer-reports/promise-details']='PromiseReports/promises/$1';
$route['customer-reports/promise-details/(:any)']='PromiseReports/promises/$1';

/// DASHBOARD
$route['load-monthlystatus']='monthlystatus/loadmonthlystatus/$1';
$route['load-custstatus']='monthlystatus/loadcuststatus/$1';
$route['load-custrec']='monthlystatus/loadcustrecovery/$1';
$route['load-saleinvoices']='monthlystatus/loadsalesinvoices/$1';
$route['load-recovery']='monthlystatus/loadrecovery/$1';
$route['load-ractivity']='monthlystatus/load_recentActivity/$1';


$route['translate_uri_dashes'] = true;
