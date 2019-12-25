@extends('app')

@section('header')


    <link rel="stylesheet" type="text/css" href="{!!url('/')!!}/css/jquery.datetimepicker.css"/ >

    <script src="{!!url('/')!!}/js/jquery.datetimepicker.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <style>
        .tag {

            width: 21px;
            height: 18px;
            padding: 5px !important;
        }

        .tag_panel {

            padding-top: 15px !important;
        }
    </style>

@stop

@section('title')
    <h1>Recipient Report</h1>
@stop

@section('content')

    <div class="leftpan">
        <div class="panel">
            <h2>Sender Details</h2>

            <div class="panelcontent">
                <ul class="review-list">
                    <li><strong>Name :</strong> {{$report['sender_name']}}</li>
                    <li><strong>Mobile No :</strong> {{$report['sender_mobile']}}</li>
                    <li><strong>Passport No :</strong> {{$sender['profile']['id_no']}}</li>
                    <li><strong>Passport Issue Date:</strong> @if($sender['profile']['passport_issue_date']!='none')
                            {{date('F d, Y', strtotime($sender['profile']['passport_issue_date']))}}

                        @else
                            {{$sender['profile']['passport_issue_date']}}
                        @endif
                    </li>
                    <li><strong>Passport Expire Date
                            :</strong> {{date('F d, Y', strtotime($sender['profile']['id_expire_date']))}}</li>
                    <li><strong>Gender:</strong> {{$sender['profile']['gender']}}</li>
                    <li><strong>Date of
                            Birth:</strong> {{date('F d, Y', strtotime($sender['profile']['date_of_birth']))}}</li>
                    <li><strong>Nationality:</strong> {{$sender['profile']['country']}}</li>
                    <li><strong>Present Address:</strong> {{$sender['profile']['present_address']}}</li>
                    <li><strong>Post Code:</strong> {{$sender['profile']['post_code']}}</li>
                    <li><strong>Occupation:</strong> {{$sender['profile']['occupation']}}</li>
                    <li><strong>Source of Income:</strong> {{$sender['profile']['source_of_income']}}</li>
                    <li><strong>Purpose of Remittance:</strong> {{$report['purpose']}}</li>
                </ul>

            </div>

        </div>
        <div class="panel">
            <h2>Receiver Details</h2>

            <div class="panelcontent">
                <ul class="review-list">
                    <li><strong>Name :</strong> {{$report['receiver_name']}}</li>
                    <li><strong>Relationship :</strong> {{$rec['relation']}}</li>
                    <li><strong>Phone Number :</strong> {{$report['receiver_mobile']}}</li>
                    <li><strong>Bank Name</strong> {{$report['bank_name']}}</li>
                    <li><strong>Bank A/C No :</strong> {{$report['bank_ac_no']}}</li>
                    <li><strong>Branch Name :</strong> {{$report['branch_name']}}</li>
                    @if(session('admin') === true)
                        <li><strong>Assisted ID :</strong> {{$rec['assisted_id']}}</li>
                    @endif
                </ul>
            </div>

        </div>


        <div class="panel"><h2>Amount</h2>
            <div class="panelcontent">
                <ul class="review-list">
                    <li><strong>Given Amount :</strong>{{$t_report['old_amount']}} {{$t_report['currency']}}</li>
                    @if($admin=='true')
                        <li><strong>MyCashPoint :</strong> {{round($t_report['amount'],2)}} Points</li>
                        <li><strong>Charges :</strong> {{$t_report['charges']}} points</li>
                        <li><strong>Commission :</strong> {{$t_report['commission']}} points</li>
                        <li><strong>Discount :</strong> {{$t_report['discount']}} points</li>
                        <li><strong>Total
                                :</strong> {{round($t_report['amount']+$t_report['charges']-$t_report['discount']-$t_report['commission'],2)}}
                            Points
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        @if($own=='true')
            <a href="{{url('/')}}/recipient/reports/{{$report['id']}}/release" class="submitbtn">Release</a>
        @endif

        @if($successrefund=='true')

        @else
            <a href="#update" class="open-popup-link submitbtn">Update</a>
        @endif


        <a href="#test-popup" class="open-popup-link submitbtn">View ID</a>
        <a href="#" id="metroprint" class="submitbtn">View Receipt</a>

        <div style="display:none">
            <div id="metroprintable" style="text-align:center;">
                <img src="https://mycashmy.com/images/mycash-point-logo.png" alt="mycash point"/>
                <br>
                ---------------------------------------------------------------------------
                <div class="details-report">

                    ORDER ID: BT{{$report['response_id']}}<br>
                    Order Date: {{$report['created_at']}}<br>

                    <h3>Order Request Slip</h3>
                    <h2>BT{{$report['response_id']}}</h2>
                    <h3>PIN No: {{$report['note']}}</h3><br>
                    Sender Name: {{$report['sender_name']}}<br>
                    Receiver Name: {{$report['receiver_name']}}<br>
                    Given Amount: {{$t_report['old_amount']}} {{$t_report['currency']}}<br>
                    ----------------------------------------------------------- <br>
                    Customer Care Line: <strong>0166421224</strong> <br>

                    This receipt is computer generated and no signature is required. T&C Apply.

                </div>
            </div>
        </div>

        @if($assignorder=='true')
            @if($admin=='true')

                <a href="#tagupdate" class="open-popup-link submitbtn">Assign Order</a>

            @endif
        @endif

        <div id="test-popup" class="white-popup mfp-hide">
            <strong>Profile Photo</strong><br><br><img src="{{$sender['profile']['profile_photo']}}" alt="" width="284"
                                                       height="269">
            <ul>
                <li><strong> Scan ID 1</strong> <img src="{{$sender['profile']['scan']}}" alt="" width="540"
                                                     height="388"></li>
                <li><strong>Scan ID 2</strong> <img src="{{$sender['profile']['scan_one']}}" alt="" width="540"
                                                    height="388"></li>
                <li><strong> Scan ID 3</strong> <img src="{{$sender['profile']['scan_two']}}" alt="" width="540"
                                                     height="388"></li>
            </ul>
        </div>

        <div id="update" class="white-popup mfp-hide">
            <form role="form" method="POST" action="{{url('/')}}/recipient/reports/{{$report['id']}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="panel">
                    <h2>Status</h2>
                    <div class="panelcontent">
                        <select class="" name="status">
                            <option value="success">Success</option>
                            <option value="cancel">Cancel</option>
                        </select>
                    </div>
                </div>
                <div class="panel">
                    <h2>Note</h2>
                    <div class="panelcontent">
                        <input type="textarea" required name="note" class="">
                    </div>
                </div>
                <div class="panel">
                    <h2>Pin Number</h2>
                    <div class="panelcontent">
                        <input type="password" name="pin" required placeholder="Enter Pin Number">
                    </div>
                </div>
                <input type="submit" value="Submit" class="submitbtn">
            </form>
        </div>

        <div id="tagupdate" class="white-popup mfp-hide">
            <form role="form" method="POST" action="{{url('/')}}/recipient/tag/{{$report['id']}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="panel">

                    <h2>Tag</h2>

                    <div class="tag_panel">

                        <input type="radio" class="tag" name="tag" value="metro"/> Metro
                        <input type="radio" class="tag" name="tag" value="city"/> City
                        <input type="radio" class="tag" name="tag" value="ucash"/> Ucash
                        <input type="radio" class="tag" name="tag" value="bank"/> Bank

                    </div>

                </div>

                <!--            <div class="panel">
                                <h2>Pin Number</h2>
                                <div class="panelcontent">
                                    <input type="password" name="pin" required placeholder="Enter Pin Number">
                                </div>
                            </div>-->

                <input type="submit" value="Submit" class="submitbtn">
            </form>
        </div>

    </div>
@stop


@section('footer')

    <script src="https://mycashmy.com/js/jQuery.print.js"></script>
    <script type="text/javascript">
        $(function () {

            $("#metroprint").on('click', function () {

                $("#metroprintable").print({
                    // Use Global styles
                    globalStyles: false,
                    // Add link with attrbute media=print
                    mediaPrint: false,
                    //Custom stylesheet
                    stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
                    //Print in a hidden iframe
                    iframe: false,
                    // Don't print this
                    noPrintSelector: ".avoid-this",
                    // Manually add form values
                    manuallyCopyFormValues: true,
                    // resolves after print and restructure the code for better maintainability
                    deferred: $.Deferred(),
                    // timeout
                    timeout: 250,
                    // Custom title
                    title: null,
                    // Custom document type
                    doctype: '<!doctype html>'

                });
            });

            $("#print").on('click', function () {

                $("#printable").print({
                    // Use Global styles
                    globalStyles: false,
                    // Add link with attrbute media=print
                    mediaPrint: false,
                    //Custom stylesheet
                    stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
                    //Print in a hidden iframe
                    iframe: false,
                    // Don't print this
                    noPrintSelector: ".avoid-this",
                    // Manually add form values
                    manuallyCopyFormValues: true,
                    // resolves after print and restructure the code for better maintainability
                    deferred: $.Deferred(),
                    // timeout
                    timeout: 250,
                    // Custom title
                    title: null,
                    // Custom document type
                    doctype: '<!doctype html>'

                });
            });

        });
    </script>

    <script>
        $(document).ready(function () {

            jQuery('#date_timepicker_start').datetimepicker({
                format: 'Y-m-d',
                onShow: function (ct) {
                    this.setOptions({
                        maxDate: jQuery('#date_timepicker_end').val() ? jQuery('#date_timepicker_end').val() : false
                    })
                },
                timepicker: false
            });


            jQuery('#date_timepicker_end').datetimepicker({
                format: 'Y-m-d',
                onShow: function (ct) {
                    this.setOptions({
                        minDate: jQuery('#date_timepicker_start').val() ? jQuery('#date_timepicker_start').val() : false
                    })
                },
                timepicker: false
            });

        });
    </script>


    <script src="{!!url('/')!!}/js/custom.js"></script>
    <script>
        $('.open-popup-link').magnificPopup({
            type: 'inline',
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });
    </script>
@stop
