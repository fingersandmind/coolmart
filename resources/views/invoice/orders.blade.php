@extends('layouts.master')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        {{-- <div class="page-header">
            <h4 class="page-title">INVOICE</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Components</a></li>
                <li class="breadcrumb-item active" aria-current="page">Invoice</li>
            </ol>
            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Edit Page</button>
        </div> --}}

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">#INV-287</h3>
            </div>

            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-6 ">
                        <p class="h3">Client Inc</p>
                        <address>
                            Street Address<br>
                            State, City<br>
                            Region, Postal Code<br>
                            ltd@example.com
                        </address>
                    </div>
                    <div class="col-lg-6 text-right">
                        <p class="h3">Invoice To</p>
                        <address>
                            Street Address<br>
                            State, City<br>
                            Region, Postal Code<br>
                            ctr@example.com
                        </address>
                    </div>
                </div>

                <div class=" text-dark">
                    <p class="mb-1 mt-5"><span class="font-weight-semibold">Invoice Date :</span> 12rd July 2018</p>
                    <p><span class="font-weight-semibold">Due Date :</span> 15th July 2019</p>
                </div>
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover">
                        <tr class=" ">
                            <th class="text-center " style="width: 1%"></th>
                            <th>Product</th>
                            <th class="text-center" style="width: 1%">Qnt</th>
                            <th class="text-right" style="width: 1%">Unit</th>
                            <th class="text-right" style="width: 1%">Amount</th>
                        </tr>
                        <tr>
                            <td class="text-center">1</td>
                            <td>
                                <p class="font-w600 mb-1">Logo Creation</p>
                                <div class="text-muted">Logo and business cards design</div>
                            </td>
                            <td class="text-center">1</td>
                            <td class="text-right">$1,800.00</td>
                            <td class="text-right">$1,800.00</td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>
                                <p class="font-w600 mb-1">Online Store Design &amp; Development</p>
                                <div class="text-muted">Design/Development for all popular modern browsers</div>
                            </td>
                            <td class="text-center">1</td>
                            <td class="text-right">$20,000.00</td>
                            <td class="text-right">$20,000.00</td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>
                                <p class="font-w600 mb-1">App Design</p>
                                <div class="text-muted">Promotional mobile application</div>
                            </td>
                            <td class="text-center">1</td>
                            <td class="text-right">$3,200.00</td>
                            <td class="text-right">$3,200.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right">Subtotal</td>
                            <td class="text-right">$25,000.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right">Vat Rate</td>
                            <td class="text-right">20%</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right">Vat Due</td>
                            <td class="text-right">$5,000.00</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-weight-bold text-uppercase text-right">Total Due</td>
                            <td class="font-weight-bold text-right">$30,000.00</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-right">
                                <button type="button" class="btn btn-primary" onClick="javascript:window.print();"><i class="si si-wallet"></i> Pay Invoice</button>
                                <button type="button" class="btn btn-secondary" onClick="javascript:window.print();"><i class="si si-paper-plane"></i> Send Invoice</button>
                                <button type="button" class="btn btn-warning" onClick="javascript:window.print();"><i class="si si-printer"></i> Print Invoice</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <p class="text-muted text-center">Thank you very much for doing business with us. We look forward to working with you again!</p>
            </div>
        </div>
    </div>
</div>
@endsection