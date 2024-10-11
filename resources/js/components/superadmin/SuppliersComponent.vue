<template>
  <div>

  <div class="container-fluid">

        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Proveedores
                <button type="button" @click="abrirModal('supplier','registrar')" class="btn btn-primary">
                    <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
                <!--<a :href="'/admin/productos/nuevo'" class="btn btn-primary"><i class="icon-plus"></i>&nbsp;Nuevo</a>
                -->
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                              <option value="name">Nombre</option>
                              <option value="description">Descripción</option>
                            </select>
                            <input type="text" v-model="buscar" class="form-control" placeholder="Texto a buscar" @keyup.enter="loadData(1,buscar,criterio,estatus)">

                            <select class="form-control col-md-3" v-model="estatus">
                                <option value="">TODOS</option>
                                <option value="active">ACTIVOS</option>
                                <option value="inactive">BAJAS</option>
                            </select>
                            <button type="submit" @click="loadData(1,buscar,criterio,estatus)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>No</th>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Estatus</th>
                            <th>Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                          <tr v-for="supplier in arraySuppliers" :key="supplier.id">
                              <td>
                                <div class="dropdown">
                                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ...
                                  </a>

                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" @click="abrirModal('supplier','ver_datos', supplier)">  <i class="fa fa-eye"></i>Ver</a></li>
                                    <li>
                                    <li>
                                      <a class="dropdown-item" href="#" @click="abrirModal('supplier','actualizar_datos', supplier)"><i class="fa fa-edit"></i>Editar</a>
                                    </li>
                                    <li>
                                        <a v-if="supplier.active" class="dropdown-item" href="#" @click="actualizarAInactivo(supplier.id)"><i class="fa fa fa-toggle-on"></i>Deshabilitar</a>
                                        <a v-else class="dropdown-item" href="#" @click="actualizarAActivo(supplier.id)"><i class="fa fa fa-toggle-off"></i>Activar</a>
                                    </li>

                                  </ul>
                                </div>

                              </td>
                              <td v-text="supplier.id"></td>
                              <td v-text="supplier.name"></td>
                              <td v-text="supplier.company"></td>
                              <td v-text="supplier.phone"></td>
                              <td v-text="supplier.email"></td>

                              <td>
                                  <span v-if="supplier.active" class="badge badge-success">Activo</span>
                                  <span v-else class="badge badge-danger">Baja</span>
                              </td>

                              <td>
                                {{ supplier.created_at | formatDate }}
                              </td>


                          </tr>

                  </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <li class="page-item" v-if="pagination.current_page > 1">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                        </li>

                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active':'']">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                        </li>

                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>

    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form v-on:submit.prevent action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                        <div v-show="error" class="form-group row div-error">
                          <div class="container-fluid">
                            <div class="alert alert-danger text-center">
                                <div v-for="error in errorMostrarMsj" :key="error" v-text="error">
                                </div>
                            </div>
                          </div>
                        </div>

                        <p><em><strong class="text text-danger">* Campos obligatorios</strong></em></p>
                        <!--tipoAccion==1 o 2: Agregar o Actualizar-->
                        <div v-if="tipoAccion==1 || tipoAccion==2 || tipoAccion==3">



                          <div class="form-group">
                            <label for="number">No. Proveedor</label>
                            <input type="text" class="form-control" v-model="number" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" v-model="name" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="alias">Alias</label>
                            <input type="text" class="form-control" v-model="alias" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="company">Empresa</label>
                            <input type="text" class="form-control" v-model="company" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="rfc">rfc</label>
                            <input type="text" class="form-control" v-model="rfc" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="curp">curp</label>
                            <input type="text" class="form-control" v-model="curp" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <hr>
                          <h3>Dirección y contacto</h3>


                          <div class="form-group">
                            <label for="address">Calle</label>
                            <input type="text" class="form-control" v-model="address" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="number_out">Num. Ext.</label>
                            <input type="text" class="form-control" v-model="number_out" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="number_int">Num. Int.</label>
                            <input type="text" class="form-control" v-model="number_int" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="district">Colonia / Distrito</label>
                            <input type="text" class="form-control" v-model="district" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="zip_code">CP</label>
                            <input type="text" class="form-control" v-model="zip_code" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="city">Ciudad</label>
                            <input type="text" class="form-control" v-model="city" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="state">Estado</label>
                            <input type="text" class="form-control" v-model="state" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="detail">Detalles</label>
                            <input type="text" class="form-control" v-model="detail" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="reference">reference</label>
                            <input type="text" class="form-control" v-model="reference" v-bind:readonly="tipoAccion === 3">
                          </div>



                          <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" v-model="phone" v-bind:readonly="tipoAccion === 3">
                          </div>
                          <div class="form-group">
                            <label for="movil">Celular</label>
                            <input type="text" class="form-control" v-model="movil" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" v-model="email" v-bind:readonly="tipoAccion === 3">
                          </div>

                          <div class="form-group">
                            <label for="observations">Observaciones extras</label>
                            <textarea class="form-control" v-model="observations"  rows="3" v-bind:readonly="tipoAccion === 3"></textarea>
                          </div>



                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSupplier()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDatosSupplier()">Actualizar</button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->

</div>
</template>

<script>
    export default {
        data(){
            return {
              arraySuppliers:[],
              pagination:{
                  'total':0,
                  'current_page':0,
                  'per_page':0,
                  'last_page':0,
                  'from':0,
                  'to':0
              },
              offset:3,
              criterio:'name',
              buscar:'',
              estatus:'active',

              supplier_id:0,
              active:0,
              number:'',
              name:'',
              alias:'',
              company:'',
              rfc:'',
              curp:'',
              email:'',
              phone:'',
              movil:'',
              address:'',
              zip_code:'',
              number_out:'',
              number_int:'',
              district:'',
              city:'',
              state:'',
              reference:'',
              detail:'',
              observations:'',


              errors:[],

              modal:0,
              tituloModal:'',
              tipoAccion:0,
              error:0,
              errorMostrarMsj:[],
            }
        },
        computed:{
           isActived: function(){
            return this.pagination.current_page;
           },
           //Calcula los elementos de la paginacion
           pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from <1){
                    from=1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to ){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
           }
        },
        methods : {

            cambiarPagina(page,buscar,criterio,estatus){
                let me = this;
                me.pagination.current_page = page;
                me.loadData(page,buscar,criterio,estatus);
            },
            loadData(page,buscar,criterio,estatus){
                let me=this;
                var url = '/superadmin/suppliers/get?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&estatus='+estatus;
                axios.get(url).then(function (response){
                    var respuesta  = response.data;
                    me.arraySuppliers = respuesta.suppliers.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    // handle error
                    console.log(error);
                  })
                  .finally(function () {
                    // always executed
                  });
            },
            actualizarAActivo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea cambiar a activo?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/superadmin/suppliers/active',{
                        'id': id
                    }).then(function (response){
                        me.loadData(me.pagination.current_page,me.buscar,me.criterio, me.estatus);
                        swalWithBootstrapButtons.fire(
                          '¡Activo!',
                          'Actualizacion exitosa.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            actualizarAInactivo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                  customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                  },
                  buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                  title: '¿Desea cambiar a inactivo?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar',
                  reverseButtons: true
                }).then((result) => {
                  if (result.value) {

                    let me=this;
                    axios.put('/superadmin/suppliers/deactive',{
                        'id': id
                    }).then(function (response){
                        me.loadData(me.pagination.current_page,me.buscar,me.criterio,me.estatus);
                        swalWithBootstrapButtons.fire(
                          '¡Inactivo!',
                          'Actualizacion exitosa.',
                          'success'
                        )
                    }).catch(function (error){
                        console.log(error);
                    });

                  }
                })
            },
            registrarSupplier(){
                if(this.validarDatos('registrar')){
                    return;
                }
                let me=this;
                axios.post('/superadmin/suppliers/store',{
                    'number':me.number,
                    'name':me.name,
                    'alias':me.alias,
                    'company':me.company,
                    'rfc':me.rfc,
                    'curp':me.curp,
                    'email':me.email,
                    'phone':me.phone,
                    'movil':me.movil,
                    'address':me.address,
                    'zip_code':me.zip_code,
                    'number_out':me.number_out,
                    'number_int':me.number_int,
                    'district':me.district,
                    'city':me.city,
                    'state':me.state,
                    'reference':me.reference,
                    'detail':me.detail,
                    'observations':me.observations,
                }).then(function (response){
                  console.log(response)
                  me.cerrarModal();
                  me.loadData(me.pagination.current_page,me.buscar,me.criterio,me.estatus)
                  Swal.fire(
                    'Exito!',
                    'Guardado correctamente.',
                    'success'
                  );
                }).catch(function (error){
                    console.log(error);
                    Swal.fire(
                        'Error!',
                        'Ocurrio un error al guardar, consulte al amdinistrador del sistema.',
                        'error'
                  );
                });
            },
            actualizarDatosSupplier(){
                if(this.validarDatos('actualizar_info')){
                    return;
                }
                let me=this;
                axios.put('/superadmin/suppliers/update',{
                    'id':me.supplier_id,
                    'number':me.number,
                    'name':me.name,
                    'alias':me.alias,
                    'company':me.company,
                    'rfc':me.rfc,
                    'curp':me.curp,
                    'email':me.email,
                    'phone':me.phone,
                    'movil':me.movil,
                    'address':me.address,
                    'zip_code':me.zip_code,
                    'number_out':me.number_out,
                    'number_int':me.number_int,
                    'district':me.district,
                    'city':me.city,
                    'state':me.state,
                    'reference':me.reference,
                    'detail':me.detail,
                    'observations':me.observations,
                }).then(function (response){
                  console.log(response)
                  me.cerrarModal();
                  me.loadData(me.pagination.current_page,me.buscar,me.criterio,me.estatus)
                  Swal.fire(
                    'Exito!',
                    'Se actualizo correctamente.',
                    'success'
                  );
                }).catch(function (error){
                    console.log(error);
                    Swal.fire(
                        'Error!',
                        'Ocurrio un error al guardar, consulte al amdinistrador del sistema.',
                        'error'
                    );
                });
            },

            validarDatos(action){
                this.error=0;
                this.errorMostrarMsj=[];

                if(!this.name) this.errorMostrarMsj.push('El nombre no puede estar vacio.');

                if(this.errorMostrarMsj.length){
                    this.error=1;
                    Swal.fire({
                        title: 'Alerta',
                        text: 'El nombre no puede estar vacio',
                        icon: 'error',
                    });
                }

                return this.error;
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "supplier":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Agregar';

                                this.number='';
                                this.name='';
                                this.alias='';
                                this.company='';
                                this.rfc='';
                                this.curp='';
                                this.email='';
                                this.phone='';
                                this.movil='';
                                this.address='';
                                this.zip_code='';
                                this.number_out='';
                                this.number_int='';
                                this.district='';
                                this.city='';
                                this.state='';
                                this.reference='';
                                this.detail='';
                                this.observations='';
                                break;
                            }
                            case 'actualizar_datos':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar Datos';


                                this.supplier_id=data['id'];
                                this.number=data['number'];
                                this.name=data['name'];
                                this.alias=data['alias'];
                                this.company=data['company'];
                                this.rfc=data['rfc'];
                                this.curp=data['curp'];
                                this.email=data['email'];
                                this.phone=data['phone'];
                                this.movil=data['movil'];
                                this.address=data['address'];
                                this.zip_code=data['zip_code'];
                                this.number_out=data['number_out'];
                                this.number_int=data['number_int'];
                                this.district=data['district'];
                                this.city=data['city'];
                                this.state=data['state'];
                                this.reference=data['reference'];
                                this.detail=data['detail'];
                                this.observations=data['observations'];
                                break;
                            }
                            case 'ver_datos':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Ver Datos';

                                this.supplier_id=data['id'];
                                this.number=data['number'];
                                this.name=data['name'];
                                this.alias=data['alias'];
                                this.company=data['company'];
                                this.rfc=data['rfc'];
                                this.curp=data['curp'];
                                this.email=data['email'];
                                this.phone=data['phone'];
                                this.movil=data['movil'];
                                this.address=data['address'];
                                this.zip_code=data['zip_code'];
                                this.number_out=data['number_out'];
                                this.number_int=data['number_int'];
                                this.district=data['district'];
                                this.city=data['city'];
                                this.state=data['state'];
                                this.reference=data['reference'];
                                this.detail=data['detail'];
                                this.observations=data['observations'];
                                break;
                            }

                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
        },
        mounted() {
            this.loadData(1,'','nombre','active');
        }
    }
</script>

<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: fixed !important;
        background-color: #3c29297a !important;
        overflow: scroll;
    }

    .div-error{
        display: flex;
        justify-content: center;
    }

    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
