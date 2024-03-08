@props(['company'])

<x-modal name="appointmentModal" id="appointmentModal" show="{{(session('errors')) ? true:false}}">
    <div class="w-full">
        <form method="post" class="" id="appointmentModalForm">
            @csrf
            @method('POST')

            <div class="py-2 px-6 bg-blue-700 sm:flex items-center sm:space-x-3 justify-between">
                <h1 class="w-full font-bold text-white">Client:</h1>
                <div class="w-full flex space-x-2 py-2 sm:py-0">
                    <x-form.select id="client" name="client" class="appointmentModalFormClient w-full">
                        <option value="">New client</option>
                        @forelse ($company->clients as $client)
                            <option @selected( old('client', request()->client) == $client->id) value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }}</option>
                        @empty
                            
                        @endforelse
                    </x-form.select>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="w-full flex space-x-4">
                    <div class="w-full" >
                        <x-form.label for="first_name" value="{{ __('Name:') }}"/>
                        <x-form.input id="first_name" name="first_name" type="text" class="w-full appointmentModalFormClientFirstName" value="{{ old('first_name') }}" required/>
                    </div>

                    <div class="w-full" >
                        <x-form.label for="last_name" value="{{ __('Surname:') }}"/>
                        <x-form.input id="last_name" name="last_name" type="text" class="w-full appointmentModalFormClientLastName" value="{{ old('last_name') }}"/>
                    </div>
                </div>

                <div class="w-full" >
                    <x-form.label for="email" value="{{ __('Email:') }}"/>
                    <x-form.input id="email" name="email" type="email" class="w-full appointmentModalFormClientEmail" value="{{ old('email') }}"/>
                </div>

                <div class="w-full" >
                    <x-form.label for="phone" value="{{ __('Phone:') }}"/>
                    <x-form.input id="phone" name="phone" type="text" class="w-full appointmentModalFormClientPhone" value="{{ old('phone') }}"/>
                </div>

                <div class="w-full" >
                    <button class="text-yellow-700 hover:underline socialMediaButton" type="button">+ social media</button>
                </div>
                

                <div class="socialMediaBlock hidden">
                    <div class="space-y-6">
                        <div class="w-full" >
                            <x-form.label for="instagram" value="{{ __('Instagram:') }}"/>
                            <x-form.input id="instagram" name="instagram" type="text" class="w-full" value="{{ old('instagram') }}" placeholder="link or @nickname"/>
                        </div>

                        <div class="w-full" >
                            <x-form.label for="telegram" value="{{ __('Telegram:') }}"/>
                            <x-form.input id="telegram" name="telegram" type="text" class="w-full" value="{{ old('telegram') }}" placeholder="link or @nickname"/>
                        </div>

                        <div class="w-full" >
                            <x-form.label for="facebook" value="{{ __('Facebook:') }}"/>
                            <x-form.input id="facebook" name="facebook" type="text" class="w-full" value="{{ old('facebook') }}" placeholder="link or @nickname"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-2 px-6 bg-blue-700 sm:flex items-center sm:space-x-3 justify-between">
                <h1 class="w-full font-bold text-white">Appointment:</h1>
                <div class="w-full flex space-x-2 py-2 sm:py-0">
                    <x-form.select id="employee" name="employee" class="w-full appointmentModalFormEmployee" required>
                        <option value="">Choose employee</option>
                        @forelse ($company->employees as $company_employee)
                            <option  value="{{ $company_employee->id }}">{{ $company_employee->user->first_name }} {{ $company_employee->user->last_name }}</option>
                        @empty
                            
                        @endforelse
                    </x-form.select>
                    <x-form.input id="date" name="date" type="date" class="w-full appointmentModalFormDate" value="{{ old('date', request('date', now()->format('Y-m-d'))) }}"/>
                </div>
            </div>
            <div class="w-full space-y-6 p-6">
                <div class="w-full" >
                    <x-form.label for="service" value="{{ __('Service:') }}"/>
                    <x-form.select id="service" name="service" class="w-full appointmentModalFormService appointmentSelector" required>
                    </x-form.select>
                </div>

                <div class="w-full" >
                    @foreach ($company->sub_services as $service)
                        <div class="flex space-x-2 items-center py-3">
                            <x-form.label for="{{ $service->slug }}" class="w-full ">
                                <div class="flex justify-between w-full items-center">
                                    <span>
                                        {{ $service->name }} ({{$service->price}})
                                    </span>
                                    <x-form.checkbox id="{{ $service->slug }}" name="sub_services[]" :value="$service->id" type="checkbox" class="appointmentModalFormSubService"/>
                                </div>
                            </x-form.label>
                        </div>
                        @if(!$loop->last) <hr> @endif
                    @endforeach
                </div>

                <div class="w-full">
                    <x-form.label for="term" value="{{ __('Term:') }}"/>
                    <x-form.input dropdown="termDropdown" id="term" name="term" type="time" class="w-full appointmentModalFormTerm" value="{{ old('term', now()->format('H:i')) }}" required/>
                    <x-form.error :messages="$errors->get('term')" class="mt-2" />
                </div>

                <div class="w-full">
                    <x-form.label for="price" value="{{ __('Price:') }}"/>
                    <x-form.input id="price" name="price" class="w-full appointmentModalFormPrice" type="number"/>
                    <x-form.error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div class="w-full">
                    <x-form.label for="comment" value="{{ __('Comment:') }}"/>
                    <x-form.textarea id="comment" name="comment" class="w-full appointmentModalFormComment"/>
                    <x-form.error :messages="$errors->get('comment')" class="mt-2" />
                </div>

                <div class="w-full">
                    <x-form.label for="status" value="{{ __('Status:') }}"/>
                    <x-form.select id="status" name="status" class="w-full appointmentModalFormStatus">
                        <option value="new">New appointment</option>
                        <option value="canceled">Canceled appointment</option>
                        <option value="done">Done appointment</option>
                        <option value="no_done">No done appointment</option>
                    </x-form.select>
                    <x-form.error :messages="$errors->get('comment')" class="mt-2" />
                </div>
            </div>
            <hr>
            <div class="flex justify-end w-full p-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Close') }}
                </x-secondary-button>
    
                <x-buttons.primary class="ml-3" type="submit" >
                    {{ __('Save') }}
                </x-buttons.primary>
            </div>
        </form>
    </div>
</x-modal>

@push('scripts')
<script>
    function showAppointmentModal(data = null) {
        const event = new CustomEvent('open-modal', { detail: 'appointmentModal' });

        if (data) {
            setAppointmentFormData(data)
        } else {
            resetAppointmentFormData();
        }

        window.dispatchEvent(event);
    }

    function setAppointmentFormData(data) {
        var form = $('#appointmentModalForm');

        if (data.type == 'appointment') {
            form.find('.appointmentModalFormClient').hide();
            form.find('.appointmentModalFormClient').hide();
            form.find('input[name=_method]').val('put');
            form.attr('action', "{{ route('admin.company.appointment.update', [$company, '']) }}/"+data.id);
        } else {
            form.find('.appointmentModalFormClient').show();
            form.find('input[name=_method]').val('post');
            form.attr('action', "{{ route('admin.company.appointment.store', $company) }}");
        } 

        setClientData(data.client ? data.client.id : null);

        setAppointmentData(data);
    }

    function resetAppointmentFormData() {
        var form = $('#appointmentModalForm');

        form.find('.appointmentModalFormClient').show();
        form.find('input[name=_method]').val('post');
        form.attr('action', "{{ route('admin.company.appointment.store', $company) }}");

        setClientData(null);

        form.find('.appointmentModalFormEmployee').val('').trigger('change');
        form.find('.appointmentModalFormComment').val('');
        form.find('.appointmentModalFormPrice').val('');
        form.find('.appointmentModalFormStatus').val('new');
        form.find('.appointmentModalFormSubService').attr('checked', false);
    }

    function setAppointmentData(data) {
        var form = $('#appointmentModalForm');

        form.find('.appointmentModalFormSubService').attr('checked', false);
        form.find('.appointmentModalFormEmployee').val(data.employee?.id);
        data.date ? form.find('.appointmentModalFormDate').val(data.date) : null;
        form.find('.appointmentModalFormTerm').val(data.term || null);
        form.find('.appointmentModalFormComment').val(data.comment || null);
        form.find('.appointmentModalFormPrice').val(data.price || data.total_price || null);
        form.find('.appointmentModalFormStatus').val(data.status || 'new');

        data.sub_services?.forEach(function(sub_service) {
            form.find('#'+sub_service.slug).attr('checked', true);
        });

        setEmployeeServices(data.employee?.id || null)
            .then(function(){
                form.find('.appointmentModalFormService').val(data.service?.id);

                setEmployeeUnoccupiedSchedule(data.employee?.id, data.service?.id, data.date || null);
            });
    }

    function setClientData(client_id) {
        var form = $('#appointmentModalForm');

        getClientData(
            client_id,
            function(data) {
                form.find('.appointmentModalFormClient').val(data.id);
                setInputDataByChar(form.find('.appointmentModalFormClientFirstName'), data.first_name);
                setInputDataByChar(form.find('.appointmentModalFormClientLastName'), data.last_name);
                setInputDataByChar(form.find('.appointmentModalFormClientEmail'), data.email);
                setInputDataByChar(form.find('.appointmentModalFormClientPhone'), data.phone);
            }
        );
    }

    function setEmployeeServices(employee_id) {
        var form = $('#appointmentModalForm');

        return new Promise(function(resolve, reject) {
            getEmployeeServices(
                employee_id,
                function(data) {
                    var options = '<option disabled>Choose service</option>';

                    data.forEach(function(element) {
                        options += "<option value='" + element.id + "'>" + element.name + " (" + element.total_price + ")" + "</option>";
                    });

                    form.find('.appointmentModalFormService').html(options);
                    resolve();
                }
            );
        });
    }

    function setEmployeeUnoccupiedSchedule (employee_id, service_id, date) {
        var dropdownBlock = $(".termDropdown").find('.dropdown-block');

        return new Promise(function(resolve, reject) {
            getEmployeeUnoccupiedSchedule(
                employee_id,
                service_id,
                date,
                function(data) {
                    dropdownBlock.html('');

                    data.forEach(function(element) {
                        var button = $("<button/>", {
                            "class": "p-2 w-full hover:bg-gray-200 text-left dropdown-option",
                            "type": "button",
                            "value": element,
                            "text": element,
                        });

                        dropdownBlock.append(button);
                    });
                }
            );
            resolve();
        });
    }

    function getClientData(client_id, onSuccess) {
        return new Promise(function(resolve, reject) {
            fetchData( '{{ route("get-client-data") }}', {
                client: client_id
            }, onSuccess);
            resolve();
        });
    };

    function getEmployeeServices(employee_id, onSuccess) {
        return new Promise(function(resolve, reject) {
            fetchData( '{{ route("get-employee-service") }}', {
                employee: employee_id
            }, onSuccess);
            resolve();
        });
    }

    function getEmployeeUnoccupiedSchedule(employee_id, service_id, date, onSuccess) {
        return new Promise(function(resolve, reject) {
            fetchData('{{ route("get-employee-unoccupied-schedule") }}', {
                employee: employee_id,
                service: service_id,
                date: date
            }, onSuccess);
            resolve();
        });
    }

    function fetchData(url, requestData, onSuccess) {
        var token = "{{ csrf_token() }}";
        requestData._token = token;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: requestData,
            success: onSuccess,
            error: function(xhr, status, error) {
                console.log("Ошибка сервера: " + error);
            }
        });
    }

    function getFormFieldValue(selector) {
        return $(selector).val();
    }

    function setFormOptions(selector, options) {
        $(selector).html(options);
    }

    function setInputDataByChar(selector, text) {
        if (text != null) {
            var textArray = text.split('');
            var displayText = "";

            var index = 0;

            var interval = setInterval(function() {
                if (index < textArray.length) {
                    displayText += textArray[index];
                    $(selector).val(displayText);
                    index++;
                } else {
                    clearInterval(interval);
                }
            }, 20);
        }else {
            $(selector).val('');
        }
    }
</script>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('.appointmentModalFormClient').change(function() {
            setClientData($(this).val());
        });

        $('.appointmentModalFormDate').change(function() {
            var form = $('#appointmentModalForm');

            form.find(('.appointmentModalFormTerm')).val(''),
            
            setEmployeeUnoccupiedSchedule(
                form.find(('.appointmentModalFormEmployee')).val(),
                form.find(('.appointmentModalFormService')).val(),
                form.find(('.appointmentModalFormDate')).val()
            );
        });

        $('.appointmentModalFormEmployee').change(function() {
            var form = $('#appointmentModalForm');

            form.find(('.appointmentModalFormTerm')).val(''),

            setEmployeeServices(form.find(('.appointmentModalFormEmployee')).val())
                .then(function() {
                    setEmployeeUnoccupiedSchedule(
                        form.find(('.appointmentModalFormEmployee')).val(),
                        form.find(('.appointmentModalFormService')).val(),
                        form.find(('.appointmentModalFormDate')).val()
                    );
                });
        });

        $('.appointmentModalFormService').change(function() {
            var form = $('#appointmentModalForm');

            setEmployeeUnoccupiedSchedule(
                form.find(('.appointmentModalFormEmployee')).val(),
                form.find(('.appointmentModalFormService')).val(),
                form.find(('.appointmentModalFormDate')).val()
            );
        });

        $('.socialMediaButton').click(function() {
            $('.socialMediaBlock').toggle('fast');
        })
    });
</script>
@endpush
