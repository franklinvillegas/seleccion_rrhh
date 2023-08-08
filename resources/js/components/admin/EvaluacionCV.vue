<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -15px;">
            <h4 class="text-color-2 mb-3">REGISTRO DE RECEPCION DE CURRICULUM</h4>
        </div>
        <br>
        <div class="form-group col-3">
            <p class="m-0">
                <strong>Convocatoria</strong>
            </p>
            <select name="convocatoria" v-model="idConvocatoria" class="form-control" data-vv-as="Convocatoria"
                placeholder="Seleccione Convocatoria" v-validate="'required'">
                <option v-for="row in listarConvocatorias" :key="row.id" :value="row.id" v-text="row.nombre"></option>
            </select>
            <!-- <span class="text-danger">{{errors.first("form_registro.nivel")}}</span> -->
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">Ingrese Número de DNI</label>
                    <input type="text" name="" class="form-control" v-model="numeroDni" @keyup.enter="buscar">
                </div>
            </div>
        </div>
        <br>
        <label><b>POSTULANTE: </b></label>
        <label v-text="evaluacion1.datos"></label>
        <label><b> - DNI:</b></label>
        <label v-text="evaluacion1.documento"></label>
        <br>
        <div v-if="idConvocatoria">
        <table class="table1 table-bordered" >
            <thead>
                <tr>
                    <th scope="col" colspan="2" style="text-align:center;background-color: #95D0FC;">FORMATO DE EVALUACION
                        DE CV PARA EL CARGO DE SUPERVISOR</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row">N° registro de CV recepcionado</td>
                    <td><input type="text" v-model="evaluacion1.num_registro" disabled></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #95D0FC;">Requisitos del Perfil</th>
                    <th style="background-color: #95D0FC;">
                        <p>Cumple con el requisito Si NO</p>
                    </th>
                </tr>
                <tr>
                    <td scope="row">Inscrito en el Registro Nacional de Proveedores (RNP)
                    </td>
                    <td><input type="radio" name="grado" v-model="evaluacion1.rnp" value="SI"> Si <input type="radio"
                            name="grado" v-model="evaluacion1.rnp" value="NO"> No </td>
                </tr>
                <tr>
                    <td scope="row">Minimo bachiller universitario,(Exepto carreras vinculadas al cuidado personal u oficios)
                    </td>
                    <td><input type="radio" name="profesion" v-model="evaluacion1.profesion" value="SI"> Si <input type="radio"
                            name="profesion" v-model="evaluacion1.profesion" value="NO"> No </td>
                </tr>
                <tr v-if="idConvocatoria==1">
                    <td scope="row">
                        <label >Manejo de herramientas de office (Procesador de textos, hoja de calculo, etc)(Constancia
                        o certificado)</label>
                        </td>
                    <td><input type="radio" name="office" v-model="evaluacion1.office" value="SI"> Si <input type="radio"
                            name="office" v-model="evaluacion1.office" value="NO"> No </td>
                </tr>
                <tr v-if="idConvocatoria==2">
                    <td scope="row">
                        <label>Manejo de hojas de cálculo Excel y herramientas de Office (DJ, constancia o certificado)</label></td>
                    <td><input type="radio" name="office" v-model="evaluacion1.office" value="SI"> Si <input type="radio"
                            name="office" v-model="evaluacion1.office" value="NO"> No </td>
                </tr>
                <tr v-if="idConvocatoria==1">
                    <td scope="row">                        
                            <label>Experiencia no menor a dos (02) años en actividades de Coordinación y supervisión de
                            procesos de recojo de información a escala nacional en el sector público o privado. o seis (06)
                            meses en coordinación/ supervisión en proyectos de aplicación de instrumentos de evaluación a nivel
                            nacional o regional.</label>
                    </td>
                    <td><input type="radio" name="experiencia" v-model="evaluacion1.criterio_cv_1" value="SI"> Si <input
                            type="radio" name="experiencia" v-model="evaluacion1.criterio_cv_1" value="NO"> No </td>
                </tr>
                <tr v-if="idConvocatoria==2">
                    <td scope="row">
                        <label >Experiencia no menor a seis (6) meses en monitoreo de procesos de recojo de
                            información a escala nacional en el sector publico o privado, o en proyectos de aplicación
                            de instrumentos de evaluación a nivel nacional o regional, o doce (12) meses en actividades de
                        Coordinación y/o supervisión de procesos de recojo de información a escala nacional en el sector 
                    público o privado; o de proyectos de aplicación de instrumentos de evaluación a nivel nacional o regional.</label>
                    </td>
                    <td><input type="radio" name="experiencia" v-model="evaluacion1.criterio_cv_1" value="SI"> Si <input
                            type="radio" name="experiencia" v-model="evaluacion1.criterio_cv_1" value="NO"> No </td>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #95D0FC;">CUMPLE CON LO SOLICITADO</th>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><label
                            :value="evaluacion1.estado_cv">SI</label> </td>
                    <td v-else><label :value="evaluacion1.estado_cv">NO</label></td>

                </tr>
                <tr>
                    <th scope="row" colspan="2"></th>
                </tr>
                <tr>
                    <th scope="row" style="background-color: #95D0FC;">CRITERIOS</th>
                    <th style="background-color: #95D0FC;">
                        <P>Calificacion (Segun puntuacion de los criterios)</P>
                    </th>
                </tr>
                <tr>
                    <td scope="row">Formacion academica</td>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><input type="text" name="formacion" v-model="evaluacion1.grado" @keypress="soloNumeros4($event)"
                            maxlength="1"> </td>
                </tr>
                <!-- de aqui es para supervisor-->
                <tr v-if="idConvocatoria==1">
                    <td scope="row">Experiencia en coordinacion/supervision en proyectos de aplicacionde instrumentos de
                        evaluacion a nivel nacional o regional</td>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><input type="text" name="expAplicacion" v-model="evaluacion1.criterio_cv_2"
                            @keypress="soloNumeros5($event)" maxlength="1"> </td>
                </tr>
                <tr v-if="idConvocatoria==1">
                    <td scope="row">Experiencia en actividades de Coordinacion y Supervison de procesos de recojo de
                        einformacion a escala nacional en el sector publico o privado</td>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><input type="text" name="expRecojo" v-model="evaluacion1.criterio_cv_3"
                            @keypress="soloNumeros5($event)" maxlength="1"> </td>
                </tr>
                <!-- de aqui es para monitor-->
                <tr v-if="idConvocatoria==2">
                    <td scope="row">Experiencia en monitoreo de procesos de recojo de información a escala nacional en el sector público o privado, o en proyectos de aplicación de instrumentos de evaluación a nivel nacional o regional.</td>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><input type="text" name="expAplicacion" v-model="evaluacion1.criterio_cv_2"
                            @keypress="soloNumeros4($event)" maxlength="1"> </td>
                </tr>
                <tr v-if="idConvocatoria==2">
                    <td scope="row">Experiencia en coordinación y/o supervisión de procesos de recojo de información a escala nacional en el sector público o privado, o en proyectos de aplicación de instrumentos de evaluación a nivel nacional o regional.</td>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><input type="text" name="expRecojo" v-model="evaluacion1.criterio_cv_3"
                            @keypress="soloNumeros5($event)" maxlength="1"> </td>
                </tr>
                <tr v-if="idConvocatoria==1">
                    <td scope="row">Es opcional: cuenta con constancio o certificaso emitido por alguna organizacion
                        indigena o centros de estudios en lengua originaria o declaracion judara en lengua originaria
                        (Ashaninka, Qechua Cusco Collao, Qechua Chanka, Shipibo-Konibo, Aymara, Awajun)</td>
                    <td v-if="evaluacion1.rnp == 'SI' && evaluacion1.office == 'SI' && evaluacion1.criterio_cv_1 == 'SI' && evaluacion1.profesion=='SI' "><input type="radio" name="lengua" v-model="evaluacion1.certificado_lengua" value="SI"> Si <input
                            type="radio" name="lengua" v-model="evaluacion1.certificado_lengua" value="NO"> No </td>
                </tr>

            </tbody>
        </table>
        <button class="btn btn-secondary float-right" type="button" @click="guardar">
            Guardar
        </button>
    </div>
        <hr>
    </div>
</template>

<script>


export default {
    name: 'Ayudas',
    components: {
    },
    data() {
        return {
            numeroDni: '',
            idConvocatoria: '',
            listarConvocatorias: [],
            filtrosBusqueda: {
                tipo: '',
                orden: 'asc',
                ordenPor: 'apellido_pat',
            },
            mostrar: {
                apellidos: '',
                nombres: '',
                provincia: '',
                num_registro: '',
            },
            evaluacion: {
                certificado_lengua: '',
                created_at: '',
                criterio_cv_1: '',
                criterio_cv_2: '',
                criterio_cv_3: '',
                criterio_cv_4: '',
                criterio_cv_5: '',
                criterio_cv_6: '',
                datos: '',
                documento: '',
                estado_cv: '',
                grado: '',
                id: '',
                num_registro: '',
                office: '',
                profesion: '',
                rnp: '',
            },
            evaluacion1: {},
        }
    },
    created() {
        this.listarConvocatoria();
    },
    methods: {
        buscar() {
            axios.get("api/evaluacion/evaluar/" + this.numeroDni + "/" + this.idConvocatoria)
                .then((response) => {
                    let data = response.data;
                    this.$toastr.s(response.data.message);
                    this.evaluacion = data.data;
                    this.evaluacion1 = this.evaluacion[0];
                    //         this.listaAlumnos.data=response.data.lista;
                    //         console.log(this.listaAlumnos);
                    // let dni = response.data;
                    // console.log(dni);
                })
                .catch((error) => {
                    console.log("error");
                });
        },
        guardar() {
            axios.post("api/evaluacion/guardar", this.evaluacion1)
                .then((response) => {
                    let data = response.data;
                    this.$toastr.s(response.data.message);
                    console.log(data);
                })
                .catch((error) => {
                    console.log("error");
                });
        },
        soloNumeros4($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 52)) { // 46 is dot
                $event.preventDefault();
            }

        },
        soloNumeros5($event) {
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 53)) { // 46 is dot
                $event.preventDefault();
            }

        },
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
    },
}
</script>
<style >.table1 th,
.table1 td {
    padding: 0.2rem;
    vertical-align: top;
    border-top: 1px solid #b5d30d;
}</style>
