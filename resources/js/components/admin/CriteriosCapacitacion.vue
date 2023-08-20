<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -15px;">
            <h4 class="text-color-2 mb-3">Registro de Notas</h4>
        </div>
        <br>
        <!--  <div class="row justify-content-md-center">
           <div class="col-md-5">
                <div class="form-group">
                    <label for="">Tipo</label>
                    <select name="" class="form-control" v-model="listarSecciones.filtrosBusqueda.tipo" @change="listarNivel" > 
                        <option value="">-- Todos -- </option>
                        <option value="1">Inicio</option>
                        <option value="2">Pregunta</option>
                        <option value="3">Publicación</option>
                    </select>
                </div>
            </div>  
        </div>
        <hr> -->

        <!-- <hr>
        <button class="btn btn-outline-secondary float-right" type="button" @click="exportar">
            <i class="fas fa-download"></i>
            Exportar 
        </button>
        <br> -->


        <div class="tab-pane fade show active" id="paso1" role="tabpanel" aria-labelledby="paso1-tab">
            <div class="row">

                <div class="form-group col-3">
                    <p class="m-0">
                        <strong>Convocatoria</strong>
                    </p>
                    <select name="convocatoria" v-model="idConvocatoria" class="form-control" data-vv-as="Convocatoria"
                        placeholder="Seleccione Convocatoria" v-validate="'required'" @change="listarAula(idConvocatoria)">
                        <option v-for="row in listarConvocatorias" :key="row.id" :value="row.id" v-text="row.nombre" >
                        </option>
                    </select>
                    <span class="text-danger">{{ errors.first("form_registro.convocatoria") }}</span>
                </div>

                    <div class="form-group col-3">
                   
                    <p class="m-0">
                        <strong>Aula</strong>
                    </p>
                    <select name="aula" v-model="aula" class="form-control" data-vv-as="Convocatoria"
                        placeholder="Seleccione Convocatoria" v-validate="'required'">
                        <option v-for="row in listarAulas" :key="row.aula" :value="row.aula" v-text="row.aula">
                        </option>
                    </select>
                    <span class="text-danger">{{ errors.first("form_registro.aula") }}</span>
                </div>
                <div class="form-group col-3">
                    <p class="m-0">
                        <strong>Generar registro de notas</strong>
                    </p>
                    <button class="btn btn-outline-success float-left" type="button" @click="generarLista"> Generar
                    </button>
                </div>

            </div>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Listado</legend>
                <div class="control-group">
                    <div class="table-responsive">
                        <vue-good-table :columns="listarRegistros.columns" :rows="listarRegistros.data" :search-options="{
                            enabled: true,
                            placeholder: 'Buscar en la tabla',
                        }">
                            <template slot="table-row" slot-scope="props">

                                <span v-if="props.column.field == 'cap_c1'">
                                    <input type="number" v-model="props.row.cap_c1" class="form-control" data-vv-as="Nota"
                                        placeholder="C1" name="cap_c1" max="5" min="0" >
                                </span>
                                <span v-else-if="props.column.field == 'cap_c2'">
                                    <input type="number" v-model="props.row.cap_c2" class="form-control" data-vv-as="Nota"
                                        placeholder="C2.1" name="cap_c2" max="5" min="0" >
                                </span>
                                <span v-else-if="props.column.field == 'cap_c3'">
                                    <input type="number" v-model="props.row.cap_c3" class="form-control" data-vv-as="Nota"
                                        placeholder="C2.1" name="cap_c3" max="5" min="0" >
                                </span>
                                <span v-else-if="props.column.field == 'asiste_d1'">
                                    <input type="checkbox" v-model="props.row.asiste_d1" data-vv-as="Nota"
                                        name="asiste_d1" >
                                </span>
                                <span v-else-if="props.column.field == 'asiste_d2'">
                                    <input type="checkbox" v-model="props.row.asiste_d2" data-vv-as="Nota"
                                        name="asiste_d2" >
                                </span>
                                <span v-else-if="props.column.field == 'asiste_d3'">
                                    <input type="checkbox" v-model="props.row.asiste_d3" data-vv-as="Nota"
                                        name="asiste_d3" >
                                </span>
                                <span v-else-if="props.column.field == 'asiste_d4'">
                                    <input type="checkbox" v-model="props.row.asiste_d4" data-vv-as="Nota"
                                        name="asiste_d4" >
                                </span>
                                <span v-else-if="props.column.field == 'asiste_d5'">
                                    <input type="checkbox" v-model="props.row.asiste_d5" data-vv-as="Nota"
                                        name="asiste_d5" >
                                </span>
                                <span v-else-if="props.column.field == 'cap_c4'">
                                    <input type="number" v-model="props.row.cap_c4" class="form-control" data-vv-as="Nota"
                                        placeholder="C1 INEI" name="cap_c4" max="5" min="0"
                                        >
                                </span>
                                <span v-else-if="props.column.field == 'cap_c5'">
                                    <input type="number" v-model="props.row.cap_c5" class="form-control" data-vv-as="Nota"
                                        placeholder="C2 INEI" name="cap_c5" max="5" min="0"
                                        >
                                </span>
                            </template>
                        </vue-good-table>
                    </div>
                    <div class="form-group col-3">
                    <button class="btn btn-outline-success float-left" type="button" @click="guardar"> Guardar
                    </button>
                </div>
                </div>
            </fieldset>
        </div>
        <div class="tab-pane fade" id="paso2" role="tabpanel" aria-labelledby="paso2-tab">

        </div>
        <div class="tab-pane fade" id="paso3" role="tabpanel" aria-labelledby="paso3-tab">

        </div>
    </div>
</template>

<script>

// import Helper from "../../services/Helper";

export default {
    name: 'Ayudas',
    components: {
    },
    data() {
        return {
            idConvocatoria: '',
            aula: '',
            idProvincia: 1,

            listarConvocatorias: [],
            listarAulas: [],
            registros: [],
            listarRegistros: {
                data: [],
                columns: [

                    { label: "N° DNI", field: "documento" },
                    { label: "Apellido y Nombres", field: "datos" },
                    { label: " C1. Desempeño durante la capacitación", field: "cap_c1" },
                    { label: "C2. Procedimientos de aplicación secundaria", field: "cap_c2" },
                    { label: "C2. Procedimientos de aplicación primaria", field: "cap_c3" },
                    { label: "Día 1", field: "asiste_d1" },
                    { label: "Día 2", field: "asiste_d2" },
                    { label: "Día 3", field: "asiste_d3" },
                    { label: "Día 4", field: "asiste_d4" },
                    { label: "Día 5", field: "asiste_d5" },
                    { label: "C1. DESEMPEÑO DURANTE LA  CAPACITACIÓN", field: "cap_c4" },
                    { label: "C2. PRUEBA ESCRITA INEI", field: "cap_c5" },
                ],
                total: 0,
                filtrosBusqueda: {
                    tipo: "",
                    orden: "asc",
                    ordenPor: "id",
                    regPagina: "10",
                },

                deshabilitarEdicion: false,
            },
        }
    },
    created() {
        this.listarConvocatoria();

    },
    methods: {
        listarConvocatoria() {
            axios.get("api/convocatoria/listar")
                .then((response) => {
                    let data = response.data;
                    this.listarConvocatorias = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
        },
        listarAula(id) {
            axios.get("api/capacitacion/aulas/" + id )
                .then((response) => {
                    let data = response.data;
                    this.listarAulas = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
        },

        limpiarFormulario() {
            this.modal = {
                titulo: '',
                nivelID: null,
                seccion: {
                    seccion: '',
                },
                deshabilitado: false,
            }
            this.$validator.reset();
        },
        guardar() {
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    this.$set(this.registros, index, { ...this.listarRegistros.data[index] });

                    axios.post("api/capacitacion/guardar", this.registros)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        modificar() {
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    axios.put("api/nivel/modificar/" + this.modal.nivelID, this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        modificarNota(id, nota) {
            const data = {
                nota,
            }
            axios.put("api/examen/modificar/" + id, data)
                .then((response) => {
                    this.$toastr.s(response);
                    this.generarLista();
                    
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });

        },
        eliminar(row, index) {
            this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                //
                axios.put("api/nivel/eliminar/" + row.id)
                    .then((response) => {
                        this.$toastr.s(response.data.message);
                        row.activo = false;
                    })
                    .catch((error) => {
                        this.$toastr.e(error.response.data.message);
                    });
                this.listarNivel();
            });

        },
        activar(row, index) {
            axios.put("api/nivel/activar/" + row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
        },
        generarLista() {
            let datos = {
                convocatoria: this.idConvocatoria,
                aula: this.aula
            }
            console.log(datos);
            axios.post("api/capacitacion/generar", datos)
                .then((response) => {
                    this.listarRegistros.data = response.data;
                    this.$toastr.s(response.data.message);
                })
                .catch((error) => {
                    console.log("error");
                });


        },
        obtenerTipo(row) {
            if (row.tipo == 1) return 'Inicio';
            else if (row.tipo == 2) return 'Pregunta';
            else if (row.tipo == 1) return 'Publicación';

        },
        exportar() {
            let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarSecciones.filtrosBusqueda);
            window.open(url);
        }

    },
}
</script>
<style >
fieldset.scheduler-border {
    border: 1px solid #dee2e6 !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1rem !important;
    font-weight: bold !important;
    text-align: left !important;
    border: none;
    width: 120px;
}
</style>