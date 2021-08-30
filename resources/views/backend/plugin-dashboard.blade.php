@extends('backend.app')


@section('dynamic-css')
<link rel="stylesheet" href="{{ assets('assets/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ assets('assets/css/chart.css') }}">
<style>
    div.pre-l::after {
        background-image: url({{ assets('assets/images/loading-spinner.gif') }});
    }
</style>
@endsection

@section('main-content')
<div class="row">
    <div class="col-12 mt-2">
        <h2 class="mb-3">Overview</h2>
        <div class="col-md-12">
            <div class="row shadow-sm mb-5 bg-white rounded-5">
                <div class="col-4 p-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="dateRange"
                            placeholder="Start to End Date">
                    </div>
                </div>

                <div class="col-5">
                    <div class="input-group">
                        <select name="slug" class="form-control plugin-select">
                            <option hidden value="0">Select Plugin</option>
                            <option value="woocommerce">WooCommerce</option>
                            <option value="contact-form-7">Contact Form 7</option>
                            <option value="classic-editor">Classic Editor</option>
                            <option value="wordpress-seo">Yoast SEO</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <button type="button" class="btn btn-primary btn-md" id="getInfo"><i class="fas fa-search"></i>
                            Search</button>
                    </div>
                </div>
            </div>

            <div class="row shadow-sm p-3 mb-5 bg-white rounded selected-plugin">
                <div class="col-4">
                    <b>Plugin:</b>
                </div>
                <div class="col-8">
                    <p class="selected-plugin-text"></p>
                </div>
            </div>
            <div class="row box-container mb-5">
                <div class="col-3">
                    <div class="activation-rate">
                        <div class="details">
                            <i class="fas fa-angle-double-up"></i>
                            <div>
                                <h1>00.0%</h1>
                                Activation Rate
                            </div>
                        </div>
                        <canvas id="activationRate"></canvas>
                    </div>
                </div>
                <div class="col-3">
                    <div class="deactivation-rate">
                        <div class="details">
                            <i class="fas fa-angle-double-down"></i>
                            <div>
                                <h1>0.0%</h1>
                                Deactivation Rate
                            </div>
                        </div>
                        <canvas id="deactivationRate"></canvas>
                    </div>
                </div>
                <div class="col-3">
                    <div class="activated">
                        <div class="details">
                            <i class="fas fa-check"></i>
                            <div>
                                <h1> <span>00.0</span></h1>
                                Activated
                            </div>
                        </div>
                        <canvas id="activated"></canvas>
                    </div>
                </div>
                <div class="col-3">
                    <div class="deactivated">
                        <div class="details">
                            <i class="fas fa-times"></i>
                            <div>
                                <h1> <span>00.0</span></h1>
                                Deactivated
                            </div>
                        </div>
                        <canvas id="deactivated"></canvas>
                    </div>
                </div>
            </div>

            <div class="row mt-2 plugin-info">
                <div class="col-6">
                    <h2>Active Install</h2>
                    <div class="shadow-sm p-4 mb-5 bg-white rounded-3">
                        <h5><span class="selected-plugin-text"></span><span class="totalActivate"></span>
                        </h5>
                    </div>
                </div>
                <div class="col-6">
                    <h2>Downloads</h2>
                    <div class="shadow-sm p-4 mb-5 bg-white rounded-3">
                        <h5><span class="selected-plugin-text"></span><span class="totalDownload"></span>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <h2>Activation / Deactivation</h2>
                <div class="shadow-sm p-4 mb-5 bg-white rounded-3 main-chart">
                    <div>
                        <canvas id="pluginChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('dynamic-js')
<script src="{{ assets('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ assets('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ assets('assets/js/Chart.min.js') }}"></script>
<script>
    //Date range picker
    $('#dateRange').daterangepicker().val('');
</script>
@endsection
