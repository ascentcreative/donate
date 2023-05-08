@php
    $giftaid = app(AscentCreative\Donate\Settings\DonateSettings::class)->enable_giftaid;    

    echo \Carbon\Carbon::now()->timestamp;
@endphp

<form id="frm_donate">

    @csrf

    <div class="form-inline">
    I would like to donate &pound;<x-forms-fields-input type="text" name="amount" label="" value="10" wrapper="none" /> 
    as a <x-forms-fields-options type="select" name="recur" value="M" :options="['S'=>'One-off', 'M'=>'Monthly']" label="" wrapper="none"/> amount.
    </div>

    <x-forms-fields-input type="text" name="name" label="Name:" value="k" wrapper="simple" />

    <x-forms-fields-input type="text" name="email" label="Email:" value="kiers@medders.org.uk" wrapper="simple" />

    @if($giftaid)
    <div class="border p-2 mt-3">
        <x-forms-fields-checkbox labelAfter="true" label="I would like to Gift Aid this and all future donations to [sitename]" name="giftaid" 
                value="0" uncheckedValue="0" wrapper="inline"/>

        <div class="small">I am a UK taxpayer and understand that if I pay less Income Tax and/or Capital Gains Tax in the current tax year than the amount of Gift Aid claimed on all my donations it is my responsibility to pay any difference.</div>
    </div>
    @endif

    <x-transact-stripe-elements buttonText="Donate Now" 
        cssSrc="https://fonts.googleapis.com/css?family=Figtree"
        :style="[
            'base' => [
                'fontFamily' => 'Figtree, sans-serif'
            ]    
        ]" />


</form>




@push('scripts')

    <script>

        $(document).ready(function() {

            $('#stripe-ui').stripeui('setStartFunction', function(resolve, reject) {

                $('.error-display').html('');

                console.log($('#frm_donate')[0]);

                data = new FormData($('#frm_donate')[0]);
                
                console.log(data);

                $.ajax({       
                    type: 'POST',
                    contentType: false,
                    url: '{{ route('donate.transact') }}',
                    processData: false,
                    // data: {
                    //     '_token': '{{ csrf_token() }}'
                    // },
                    data: data,
                    headers: {
                        'Accept' : "application/json"
                    }
                }).done(function(data, xhr, request) {
                    // resolve('force-fail');
                    resolve(data); // return the PaymentIntent
                }).fail(function(data) {
                    // console.log(data.status);
                    switch(data.status) {
                            case 422:
                                // validation fail
                                let errors = flattenObject(data.responseJSON.errors);
                                console.log(errors);
                                for(fldname in errors) { 

                                    let undotArray = fldname.split('.');
                                    for(i=1;i<undotArray.length;i++) {
                                        undotArray[i] = '[' + undotArray[i] + ']';
                                    }
                                    aryname = undotArray.join('');

                                    val = errors[fldname];

                                    if(typeof val == 'object') {
                                        //fldname = fldname + '[]';
                                        val = Object.values(val).join('<BR/>');
                                    }

                                    
                                    $('.error-display[for="' + aryname + '"]').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
                                    val + 
                                    '</small>');

                                }

                                // need to display these errors:
                            break;

                            default:
                                // something else
                                alert(data.statusText + " - " + data.responseJSON.message);
                        }


                    reject(data.statusText);
                });

            });

            $('#stripe-ui').stripeui('setFailFunction', function(error) {
                //alert('custom fail');
            }); 

        });

        $(document).on('transact-success', function() {
            alert('donation complete');
        });

        function flattenObject(ob) {
            var toReturn = {};

            for (var i in ob) {
                if (!ob.hasOwnProperty(i)) continue;

                if ((typeof ob[i]) == 'object' && ob[i] !== null) {
                    var flatObject = this.flattenObject(ob[i]);
                    for (var x in flatObject) {
                        if (!flatObject.hasOwnProperty(x)) continue;

                        toReturn[i + '.' + x] = flatObject[x];
                    }
                } else {
                    toReturn[i] = ob[i];
                }
            }
            return toReturn;
        }

    </script>

@endpush