@extends('layouts.app')

@section('title', 'Payments Report')

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Piutang Report</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
      
<div wire:id="yfMJMM43Hc1k6S3Klil4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form wire:submit.prevent="generateReport">
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Start Date <span class="text-danger">*</span></label>
                                    <input wire:model.defer="start_date" type="date" class="form-control" name="start_date">
                                                                    </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>End Date <span class="text-danger">*</span></label>
                                    <input wire:model.defer="end_date" type="date" class="form-control" name="end_date">
                                                                    </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Payments</label>
                                    <select wire:model="payments" class="form-control" name="payments">
                                        <option value="">Select Payments</option>
                                        <option value="sale">Sales</option>
                                        <option value="sale_return">Sale Returns</option>
                                        <option value="purchase">Purchase</option>
                                        <option value="purchase_return">Purchase Returns</option>
                                    </select>
                                                                    </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select wire:model.defer="payment_method" class="form-control" name="payment_method">
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <span wire:target="generateReport" wire:loading="" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <i wire:target="generateReport" wire:loading.remove="" class="bi bi-shuffle"></i>
                                Filter Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

            <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="alert alert-warning mb-0">
                          ini Hutang
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>











    </div>
@endsection
