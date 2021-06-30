@extends('layouts.app')

@section('content')
<div class="container">
    <div id = "register-container" class="row justify-content-center" v-show="ready" style="display:none" v-init:countries = '@json(App\Models\Country::all())'>
        @verbatim
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">User Registration</div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" required autocomplete="name" autofocus v-model="user.name" :class="{'is-invalid':errors.name}">
                                    <span class="invalid-feedback d-block" role="alert" v-if = "errors.name">
                                        <strong v-for="error in errors.name">{{error}}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" v-model="user.email" :class="{'is-invalid':errors.email}">
                                    <span class="invalid-feedback d-block" role="alert" v-if = "errors.email">
                                        <strong v-for="error in errors.email">{{error}}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label  class="col-md-4 col-form-label text-md-right">Identification Card</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="identification_card" required minlength="11" maxlength="11" @keypress="onlyNumbers" v-model="user.identification_card"  :class="{'is-invalid':errors.identification_card}">
                                    <span class="invalid-feedback d-block" role="alert" v-if = "errors.identification_card">
                                        <strong v-for="error in errors.identification_card">{{error}}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birth_date" class="col-md-4 col-form-label text-md-right">Birth Date</label>

                                <div class="col-md-6">
                                    <input id="birth_date" type="date" class="form-control" name="birth_date" :max="maxDate" required v-model="user.birth_date">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cellphone_number" class="col-md-4 col-form-label text-md-right">Cellphone Number</label>

                                <div class="col-md-6">
                                    <input id="cellphone_number" type="text" class="form-control" name="cellphone_number" placeholder="Opcional" @keypress="onlyNumbers" v-model="user.cellphone_number">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" v-model="user.password" :class="{'is-invalid':errors.password}">
                                    <span class="invalid-feedback d-block" role="alert" v-if = "errors.password">
                                        <strong v-for="error in errors.password">{{error}}</strong>
                                    </span>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" v-model="user.password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">Country</label>

                                <div class="col-md-6">
                                    <select class="form-control" name="country"  required  v-model="countryId">
                                        <option disabled selected value="">Select Country</option>
                                        <option v-for="country in countries" :value="country.id">
                                            {{country.code}} - {{country.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">State</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="state" required v-model="stateId" :disabled="!countryId">
                                        <option disabled selected value="">Select State</option>
                                        <option v-for="state in states" :value="state.id">
                                            {{state.code}} - {{state.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">City</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="state" required v-model="user.city_id" :disabled="!stateId">
                                        <option disabled selected value="">Select City</option>
                                        <option v-for="city in cities" :value="city.id">
                                            {{city.code}} - {{city.name}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endverbatim
    </div>

    <script src="{{ mix('js/register.js') }}" defer></script>
    <style>
        form strong{
            display: block;
        }
    </style>
</div>
@endsection
