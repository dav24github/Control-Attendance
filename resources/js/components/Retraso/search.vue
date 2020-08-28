<template>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="row">                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="retrasoDate">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">                                            
                                                <label >Rango de fechas</label>                                         
                                                <input type="checkbox" v-on:click="showHide(visto)" checked>
                                            </div>                          
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fecha inicial &nbsp &nbsp</label>     
                                                <input type="date" class="form-control" v-model="form.i_date">
                                                <small class="text-danger" v-if="errors.i_month">{{errors.i_month[0]}}</small>
                                            </div>
                                        </div>   
                                        <div class="col-md-6" v-if="visto">
                                            <div class="form-group">                                             
                                                <label>Fecha final &nbsp &nbsp</label>                                                  
                                                <input type="date" class="form-control" v-model="form.f_date">
                                                <small class="text-danger" v-if="errors.f_month">{{errors.f_month[0]}}</small>
                                            </div>
                                        </div> 
                                        <div class="col-md-12">
                                            <div class="form-group">                                   
                                                <button class="btn btn-success mt-2" type="submit">Buscar</button> 
                                            </div>
                                        </div>
                                    </div>
                                </form>  
                            </div>
                        </div>                                             
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form @submit.prevent="retrasoMonth">                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Mes &nbsp &nbsp</label>                
                                                <select v-model="form.month" class="form-control " id="">
                                                    <option value="">--select month--</option>
                                                    <option value="January">January</option>
                                                    <option value="February">February</option>
                                                    <option value="March">March</option>
                                                    <option value="April">April</option>
                                                    <option value="May">May</option>
                                                    <option value="June">June</option>
                                                    <option value="July">July</option>
                                                    <option value="August">August</option>
                                                    <option value="September">September</option>
                                                    <option value="October">October</option>
                                                    <option value="November">November</option>
                                                    <option value="December">December</option>
                                                </select>
                                                <small class="text-danger" v-if="errors.f_month">{{errors.f_month[0]}}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">                                   
                                                <button class="btn btn-success mt-2" type="submit">Buscar</button> 
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h4>Lista de Retrasos</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tbody><tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Total de Retrasos</th>
                                </tr>
                                <tr v-for="retraso,index in retrasos">   
                                    <th>{{index+1}}</th>                               
                                    <td>{{retraso.nombre}}</td>   
                                    <td>{{retraso.totalRetrasos}}</td>    
                                </tr>                               
                                </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "retrasoDetails",
        data(){
            return {
                retrasos:[],
                form:{
                    i_date:'',
                    f_date:'',
                    month:'',
                },                
                errors:{},
                searchFillter:'',
                visto: true
            }
        },
        methods:{
            fecha_formato : function( date ) {
                if(date!="") return moment( date ).format("DD/MM/YYYY");
                else "";
            },
            allRetrasos(){
                axios.get('api/retrasos')
                    .then(res=>{
                        this.retrasos = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            retrasoMonth(){
                console.log(this.form);
                axios.post('api/retraso-month',this.form)
                    .then(res=>{
                        this.retrasos = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            retrasoDate(){
                
                console.log(this.form);
                axios.post('api/retraso-date',this.form)
                    .then(res=>{
                        this.retrasos = res.data;
                        console.log(res.data)
                    }).catch(error=>{console.log(error.response.data)});
            },
            showHide(visto) {      
                if (visto){                   
                    this.form.i_date = '';
                    this.form.f_date = '';
                }                
                this.visto = !visto;   
            },
        },
        created() {
            this.allRetrasos();
        },
        mounted() {
            if(!User.loggedIn()){
                Toast.fire({
                    icon: 'warning',
                    title: 'Inicia sesión primero!',
                });
                this.$router.push({name:'login'})
            }

        },
    }
</script>

<style scoped>

</style>
