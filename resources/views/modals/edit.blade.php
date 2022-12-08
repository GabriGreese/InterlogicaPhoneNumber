<div class="row gy-2 gx-3">
    <p>Edit number: <?= $number->sms_phone ?></p>

    <div class="badge-area">
        @if($correctness['status'])
            <div class="badge bg-success">Number is formally correct</div>
        @else
            <div class="badge bg-danger"><p>Number is not formally correct or malformed</p>
                <p>Suggested: <a href="javascript:void(0);" class="fill-number">{!! $correctness['suggested'] !!}</a></p>
            </div>
        @endif
    </div>

    {!! Form::open()->route('number.update', [$number->id])->fill($number) !!}
    <div class="col-md-12">
        {!! Form::text('sms_phone', 'Phone #')->attrs(['class' => 'form-control'])->required() !!}
    </div>
    <div class="col-md-12 mt-2">
        {!! Form::submit('<i class="fa fa-fw fa-lg fa-check-circle"></i> Update') !!}
        {!! Form::button('<i class="fa fa-fw fa-lg fa-times-circle"></i> Close')->attrs(['data-bs-dismiss'=>'modal']) !!}
    </div>
    {!!Form::close()!!}
    <script>
        // check for correctness via AJAX
        var checkCorrectness = function (number) {
            $badge_area = $('.badge-area');
            $.ajax({
                type: 'POST',
                url: '{!! route('number.checkCorrectness') !!}',
                data: {sms_phone: number},
                success: function (data) {
                    html = '';
                    if (data.status) {
                        html = '<div class="badge bg-success">Number is formally correct</div>';
                    } else {
                        html = '<div class="badge bg-danger"><p>Number is not formally correct or malformed</p>\
                                    <p>Suggested: <a href="javascript:void(0);" class="fill-number">' + data.suggested + '</a></p>\
                                </div>';
                    }
                    $badge_area.html(html);
                    initClickSuggested();
                },
                error: function () {
                    alert('error checking correctness');
                }
            });
        };

        /**
         * Start a trigger for the number suggested link
         */
        var initClickSuggested = function () {
            $('.fill-number').unbind('click').on('click', function (e) {
                $input_sms_phone.val($(e.currentTarget).html());
            });
        };

        $(document).ready(function () {
            $input_sms_phone = $('input[name="sms_phone"]');
            // write the suggested number in the field...
            initClickSuggested();

            // check for correctness in realtime...
            $input_sms_phone.on('keyup', function () {
                checkCorrectness($input_sms_phone.val());
            });
        })
    </script>

</div>
