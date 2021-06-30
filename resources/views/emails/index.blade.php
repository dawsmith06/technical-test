@extends('layouts.app')

@section('content')
    <div id = "emails-container" class = "pl-1 pr-1" v-show = "ready" style = "display:none;">
        <div class="row m-0">
            <div class="col-6 mt-4 pb-1 pl-1 pr-1">
                <button class  = "btn btn-warning p-1 pl-2 pr-2 active" @click="showModal('#emails-form')">
                    Add
                </button>
            </div>

            <div class="col-6 mt-4 pb-1 pl-1 pr-1 text-right">
                <input class="form-control float-right me-2" type="search" placeholder="To Search type and enter" style = "width:200px" v-model="search" @keyup.enter="getEmails()">
            </div>
        </div>

        <div id = "page-list">
            @verbatim
                <table class="table table-sm table-bordered" id="emails-table">
                    <thead class = "thead-light text-center">
                        <tr>
                            <th width = "40">#</th>

                            <th v-for = "(column,name) in columns" @click="orderBy(name)">
                                {{column.title}}
                                <span class="float-right" v-if = "order.column == name && order.mode=='ASC'">&#8593;</span>
                                <span class="float-right" v-if = "order.column == name && order.mode=='DESC'">&#8595;</span>
                            </th>
                        </tr>
                    </thead>
        
                    <tbody>
                        <tr class  = "text-center" v-for  = "(email,key) in emails" height = "20">
                            <td> {{key + 1}} </td>
                            <td> {{email.id}} </td>
                            <td> {{email.user.email}} </td>
                            <td> {{email.to}} </td>
                            <td> {{email.subject}} </td>
                            <td>
                                <button class="btn btn-sm" @click="alert('Message',email.message,'info',false)">
                                    <img src="https://image.flaticon.com/icons/png/512/855/855502.png" width="15">
                                </button>
                            </td>
                            <td> {{email.status}} </td>
                        </tr>
                    </tbody>
                </table>
                <pagination-links class = "float-left" :data = "pagination" @change = "onPageChange"></pagination-links>
            @endverbatim
        </div>

        <div id = "page-form">
            <div class="modal fade" id="emails-form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header btn-primary active">
                        <h5 class="modal-title">New Email</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form method="POST" @submit.prevent="store" class="text-left">
                                <div class="form-group">
                                    <label for="name" class="col-form-label text-md-right">To</label>
                                    <input type="emamil" class="form-control" name="to" required autocomplete="name" v-model="email.to">
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-form-label text-md-right">Subject</label>
                                    <input type="text" class="form-control" name="subject" required autocomplete="name" v-model="email.subject">
                                </div>

                                <div class="form-group">
                                    <label for="name" class="col-form-label text-md-right">Message</label>
                                    <textarea class="form-control text-justify" name="message" required cols="30" rows="6" v-model="email.message"></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/emails.js') }}?v=<?=time()?>" defer></script>
    <link href="{{ asset('css/emails.css') }}" rel="stylesheet">
@endsection