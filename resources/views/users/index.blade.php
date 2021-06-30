@extends('layouts.app')

@section('content')
    <div id = "users-container" class = "pl-1 pr-1" v-show = "ready" style = "display:none;">
        <div class="row m-0">
            <div class="col-6 mt-4 pb-1 pl-1 pr-1">
                <a href = "/register" class  = "btn btn-warning p-1 pl-2 pr-2 active">
                    Add
                </a>

                <button class  = "btn btn-primary ml-2 p-1 pl-2 pr-2 active" :disabled = "!hasChanges" @click = "$refs.submitBtn.click()">
                    Save
                </button>
            </div>

            <div class="col-6 mt-4 pb-1 pl-1 pr-1 text-right">
                <input class="form-control float-right me-2" type="search" placeholder="To Search type and enter" style = "width:200px" v-model="search" @keyup.enter="getUsers()">
            </div>
        </div>

        <div id = "page-list">
            @verbatim
                <form  method="POST" @submit.prevent = "update">
                    <table class="table table-xs table-bordered" id="users-table">
                        <thead class = "thead-light text-center">
                            <tr>
                                <th width = "40">#</th>

                                <th v-for = "(column,name) in columns" @click="orderBy(name)">
                                    {{column.title}}
                                    <span class="float-right" v-if = "order.column == name && order.mode=='ASC'">&#8593;</span>
                                    <span class="float-right" v-if = "order.column == name && order.mode=='DESC'">&#8595;</span>
                                </th>
                                
                                <th></th>
                            </tr>
                        </thead>
            
                        <tbody>
                            <tr class  = "text-center" v-for  = "(user,key) in users" height = "20">
            
                                <td> {{key + 1}} </td>

                                <td> {{user.id}} </td>
            
                                <td>
                                    <input type="text"  
                                        @change="onChange('name',user)"
                                        v-model="user.name"                        
                                        required
                                    />  
                                </td>

                                <td>
                                   {{user.email}}
                                </td>

                                <td>
                                   {{user.identification_card}}
                                </td>

                                <td>
                                    <input type="text"  
                                        @change="onChange('cellphone_number',user)"
                                        v-model="user.cellphone_number"                        
                                        placeholder="--"
                                    />  
                                </td>

                                <td>
                                    <input  
                                        type="date"
                                        @change="onChange('birth_date',user)"
                                        v-model="user.birth_date"                        
                                        :max="maxDate"
                                        required
                                    />  
                                </td>

                                <td>
                                   {{user.age}}
                                </td>

                                <td>
                                   {{user.city.name}}
                                </td>


                                <td>
                                   <a href="#" @click="confirmDestroy(user)" title="Delete User">
                                    ⛔
                                   </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            
                    <button type = "submit" v-show = "false" ref = "submitBtn"></button>
                </form>
                
                <pagination-links class = "float-left" :data = "pagination" @change = "onPageChange"></pagination-links>
            @endverbatim
        </div>
    </div>

    <script src="{{ asset('js/users.js') }}?v=<?=time()?>" defer></script>
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endsection