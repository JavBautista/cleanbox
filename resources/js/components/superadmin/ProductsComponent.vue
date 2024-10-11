<template>
  <div>

  <div class="container-fluid">

        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Productos
                <button type="button" @click="abrirModal('product','registrar')" class="btn btn-primary">
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
                            <th>Descripcion</th>
                            <th>Estatus</th>
                            <th>Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                          <tr v-for="product in arrayProducts" :key="product.id">
                              <td>
                                <div class="dropdown">
                                  <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ...
                                  </a>

                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" @click="abrirModal('product','ver_datos', product)">  <i class="fa fa-eye"></i>Ver</a></li>
                                    <li>
                                    <li>
                                      <a class="dropdown-item" href="#" @click="abrirModal('product','actualizar_datos', product)"><i class="fa fa-edit"></i>Editar</a>
                                    </li>
                                    <li>
                                        <a v-if="product.active" class="dropdown-item" href="#" @click="actualizarAInactivo(product.id)"><i class="fa fa fa-toggle-on"></i>Deshabilitar</a>
                                        <a v-else class="dropdown-item" href="#" @click="actualizarAActivo(product.id)"><i class="fa fa fa-toggle-off"></i>Activar</a>
                                    </li>

                                  </ul>
                                </div>

                              </td>
                              <td v-text="product.id"></td>
                              <td v-text="product.name"></td>
                              <td v-text="product.description"></td>

                              <td>
                                  <span v-if="product.active" class="badge badge-success">Activo</span>
                                  <span v-else class="badge badge-danger">Baja</span>
                              </td>

                              <td>
                                {{ product.created_at | formatDate }}
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
                            <label for="category_id">category_id</label>
                            <input type="text" class="form-control" v-model="category_id" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="active">active</label>
                            <input type="text" class="form-control" v-model="active" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="key">key</label>
                            <input type="text" class="form-control" v-model="key" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="key_alt">key_alt</label>
                            <input type="text" class="form-control" v-model="key_alt" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="barcode">barcode</label>
                            <input type="text" class="form-control" v-model="barcode" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" class="form-control" v-model="name" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="description">description</label>
                            <input type="text" class="form-control" v-model="description" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="purcahse_unit">purcahse_unit</label>
                            <input type="text" class="form-control" v-model="purcahse_unit" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="sales_unit">sales_unit</label>
                            <input type="text" class="form-control" v-model="sales_unit" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="factor">factor</label>
                            <input type="text" class="form-control" v-model="factor" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="tax">tax</label>
                            <input type="text" class="form-control" v-model="tax" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="net">net</label>
                            <input type="text" class="form-control" v-model="net" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="cost">cost</label>
                            <input type="text" class="form-control" v-model="cost" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="price_1">price_1</label>
                            <input type="text" class="form-control" v-model="price_1" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="price_2">price_2</label>
                            <input type="text" class="form-control" v-model="price_2" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="price_3">price_3</label>
                            <input type="text" class="form-control" v-model="price_3" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="price_4">price_4</label>
                            <input type="text" class="form-control" v-model="price_4" v-bind:readonly="tipoAccion===3">
                          </div>

                          <div class="form-group">
                            <label for="url_video">url_video</label>
                            <input type="text" class="form-control" v-model="url_video" v-bind:readonly="tipoAccion===3">
                          </div>


                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrar()">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarDatos()">Actualizar</button>

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
              arrayProducts:[],
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

              product_id:0,
              category_id:0,
              active:0,
              key:'',
              key_alt:'',
              barcode:'',
              name:'',
              description:'',
              purcahse_unit:'',
              sales_unit:'',
              factor:'',
              tax:'',
              net:'',
              cost:0,
              price_1:0,
              price_2:0,
              price_3:0,
              price_4:0,
              url_video:'',



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
                var url = '/superadmin/products/get?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&estatus='+estatus;
                axios.get(url).then(function (response){
                    var respuesta  = response.data;
                    me.arrayProducts = respuesta.products.data;
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
                    axios.put('/superadmin/products/active',{
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
                    axios.put('/superadmin/products/deactive',{
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
            registrar(){
                if(this.validarDatos('registrar')){
                    return;
                }
                let me=this;
                axios.post('/superadmin/products/store',{
                    'category_id':me.category_id,
                    'active':me.active,
                    'key':me.key,
                    'key_alt':me.key_alt,
                    'barcode':me.barcode,
                    'name':me.name,
                    'description':me.description,
                    'purcahse_unit':me.purcahse_unit,
                    'sales_unit':me.sales_unit,
                    'factor':me.factor,
                    'tax':me.tax,
                    'net':me.net,
                    'cost':me.cost,
                    'price_1':me.price_1,
                    'price_2':me.price_2,
                    'price_3':me.price_3,
                    'price_4':me.price_4,
                    'url_video':me.url_video,
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
            actualizarDatos(){
                if(this.validarDatos('actualizar_info')){
                    return;
                }
                let me=this;
                axios.put('/superadmin/products/update',{
                    'id':me.product_id,
                    'category_id':me.category_id,
                    'active':me.active,
                    'key':me.key,
                    'key_alt':me.key_alt,
                    'barcode':me.barcode,
                    'name':me.name,
                    'description':me.description,
                    'purcahse_unit':me.purcahse_unit,
                    'sales_unit':me.sales_unit,
                    'factor':me.factor,
                    'tax':me.tax,
                    'net':me.net,
                    'cost':me.cost,
                    'price_1':me.price_1,
                    'price_2':me.price_2,
                    'price_3':me.price_3,
                    'price_4':me.price_4,
                    'url_video':me.url_video,
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
                    case "product":{
                        switch(accion){
                            case 'registrar':{
                                this.modal=1;
                                this.tipoAccion =1;
                                this.tituloModal='Agregar';

                                this.product_id=0;
                                this.category_id=0;
                                this.active=0;
                                this.key='';
                                this.key_alt='';
                                this.barcode='';
                                this.name='';
                                this.description='';
                                this.purcahse_unit='';
                                this.sales_unit='';
                                this.factor='';
                                this.tax='';
                                this.net='';
                                this.cost=0;
                                this.price_1=0;
                                this.price_2=0;
                                this.price_3=0;
                                this.price_4=0;
                                this.url_video='';
                                break;
                            }
                            case 'actualizar_datos':{
                                this.modal=1;
                                this.tipoAccion =2;
                                this.tituloModal='Actualizar Datos';


                                this.product_id=data['id'];
                                this.category_id=data['category_id'];
                                this.active=data['active'];
                                this.key=data['key'];
                                this.key_alt=data['key_alt'];
                                this.barcode=data['barcode'];
                                this.name=data['name'];
                                this.description=data['description'];
                                this.purcahse_unit=data['purcahse_unit'];
                                this.sales_unit=data['sales_unit'];
                                this.factor=data['factor'];
                                this.tax=data['tax'];
                                this.net=data['net'];
                                this.cost=data['cost'];
                                this.price_1=data['price_1'];
                                this.price_2=data['price_2'];
                                this.price_3=data['price_3'];
                                this.price_4=data['price_4'];
                                this.url_video=data['url_video'];
                                break;
                            }
                            case 'ver_datos':{
                                this.modal=1;
                                this.tipoAccion =3;
                                this.tituloModal='Ver Datos';

                                this.product_id=data['id'];
                                this.category_id=data['category_id'];
                                this.active=data['active'];
                                this.key=data['key'];
                                this.key_alt=data['key_alt'];
                                this.barcode=data['barcode'];
                                this.name=data['name'];
                                this.description=data['description'];
                                this.purcahse_unit=data['purcahse_unit'];
                                this.sales_unit=data['sales_unit'];
                                this.factor=data['factor'];
                                this.tax=data['tax'];
                                this.net=data['net'];
                                this.cost=data['cost'];
                                this.price_1=data['price_1'];
                                this.price_2=data['price_2'];
                                this.price_3=data['price_3'];
                                this.price_4=data['price_4'];
                                this.url_video=data['url_video'];
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
