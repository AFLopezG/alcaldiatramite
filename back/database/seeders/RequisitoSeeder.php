<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequisitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('requisitos')->insert([
            ['detalle'=>'Formulario Unico de Solicitud de Tramite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 y FORM 023).'],
            ['detalle'=>'Autorización de Línea y Nivel vigente.'],
            ['detalle'=>'Testimonio de Propiedad y Folio Real debidamente registrado en Derechos Reales (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Pago de impuestos de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Planos Arquitectónicos, debidamente firmado por profesional independiente registrado en el colegio correspondiente (con dos copias).'],
            ['detalle'=>'Planos Sanitarios debidamente firmado por profesional independiente registrado en el colegio correspondiente (con dos copias).'],
            ['detalle'=>'Para construcciones iguales o mayores a tres (3) plantas, planos estructurales con estudio de suelo, memoria de cálculo estructural e hidrosanitario, debidamente firmado por profesional independiente registrado en el colegio correspondiente (con dos copias).'],
            ['detalle'=>'Para construcciones iguales o mayores a tres (3) plantas, deberá presentarse Contrato de Obra entre el propietario y el profesional técnico, o persona jurídica debidamente habilitada para el rubro, responsable de la obra.'],
            ['detalle'=>'Para construcciones iguales o mayores a tres (3) plantas, deberá presentarse Contrato de Supervisión entre el propietario y el profesional técnico, o persona jurídica debidamente habilitada para el rubro, responsable de la supervisión de la obra.'],
            ['detalle'=>'Plano Demostrativo en Propiedad Horizontal con corte esquemático (original y fotocopia) firmado por profesional independiente debidamente registrado en el colegio correspondiente.'],
            ['detalle'=>'Testimonio de Propiedad del inmueble con Folio Real y registrado en Derechos Reales, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal Oruro.'],
            ['detalle'=>'Planos arquitectónicos del inmueble, debidamente aprobados por el Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Testimonio de Propiedad Horizontal del departamento, piso o demás dependencias a ser aprobadas por el Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Fotocopias del pago de Impuestos a la Propiedad de Bienes Inmuebles y Tasas y Patentes de las dos (12) últimas gestiones, debidamente visadas por la Secretaría Municipal de Asuntos Jurídicos.'],
            ['detalle'=>'Fotocopia de la cédula de identidad del titular'],
            ['detalle'=>'Declaración Jurada ante Notario de Fe Pública, expresando que el terreno a urbanizar no se encuentra en proceso judicial o administrativo y tampoco tiene limitación judicial, constituyéndose el usuario responsable ante la ley de los perjuicios y daños que pudiera ocasionar con su declaración voluntaria.'],
            ['detalle'=>'Fotocopia de Testimonio de Propiedad del inmueble con Folio Real registrado en Derechos Reales, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal Oruro'],
            ['detalle'=>'En caso de persona jurídica, testimonio poder específico para la realización del presente tramite con una antigüedad en favor del apoderado de máximo tres meses de antigüedad en original, testimonio de constitución de personería jurídica y fotocopia de carnet del apoderado'],
            ['detalle'=>'Fotocopia del pago de Impuestos de Bienes Inmuebles y Tasas y Patentes de las 3 últimas gestiones. (debidamente visado por la Secretaria Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Fotocopias de cédula de identidad del propietario.'],
            ['detalle'=>'En caso de apoderados deberán presentar Poder Especial y Suficiente en original o fotocopia debidamente legalizada por autoridad competente y una fotocopia de su cédula de identidad del poderdante.'],
            ['detalle'=>'Certificado de Uso de Suelo original o fotocopia legalizada por la Secretaria Municipal de Gestión Territorial, más comprobante de caja original o fotocopia (debidamente visado por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Plano Topográfico Georeferenciado aprobado original o fotocopia legalizada por la Secretaria Municipal de Gestión Territorial, más comprobante de caja original o fotocopia (debidamente visado por la Secretaría Municipal de Asuntos Juridicos).'],
            ['detalle'=>'Planos de urbanización completos, debidamente acotados y emplazados en el plano topográfico georreferenciado aprobado, con determinación de aceras, ochaves, anchos de vía, nominación de avenidas, calles, manzanos, predios y otros datos técnicos propios de un plano de urbanización, firmados por profesional arquitecto independiente, en ocho (8) ejemplares, destinados al Usuario, Archivo Técnico, Catastro Urbano, Derechos Reales y E.N.D.E. (mismos que deben estar en escala legible y presentados en papel pliego bond).'],
            ['detalle'=>'Planos Sanitarios, firmados por profesional independiente con 10 ejemplares, destinados al Usuario, Archivo Técnico, Catastro Urbano, Derechos Reales, SeLA y Drenaje Urbano.'],
            ['detalle'=>'Memoria de cálculo hidrosanitario en original y dos copias.'],
            ['detalle'=>'Planos demostrativos y georeferenciados originales de cada una de las áreas verdes, y equipamientos, debidamente identificadas más minuta de trasferencia de las áreas cedidas a favor del Gobierno Autónomo Municipal de Oruro por el o los propietarios de la urbanización (físico y digital) para su registro en oficinas de Derechos Reales, en dos ejemplares.'],
            ['detalle'=>'Plano topográfico de mojones firmado por profesional independiente en tres ejemplares destinados al Usuario y al Gabinete de Topografía de la Entidad.'],
            ['detalle'=>'Memoria de Calculo Hidráulico original, más dos copias.'],
            ['detalle'=>'En formato digital (Cd) se deberá incluir lo siguiente: Plano Topográfico, Plano Arquitectónico de Urbanización en coordenadas reales, Plano Sanitario, Pluvial, de agua potable y tabla de relación de superficies.'],
            ['detalle'=>'Fotocopia del Testimonio de propiedad debidamente registrado en oficinas de Derechos Reales o minuta de transferencia y Testimonio de propiedad del vendedor registrado en oficinas de Derechos Reales de la cual se genera, debidamente visados por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Fotocopia de la cédula de identidad del propietario.'],
            ['detalle'=>'Fotocopia legalizada del comprobante de pago del Impuesto a la Propiedad de Bienes Inmuebles y Tasas y Patentes del predio de los tres (3) últimos años.'],
            ['detalle'=>'Plano Topográfico georeferenciado firmado por un profesional independiente debidamente registrado en el colegio correspondiente (tres ejemplares).'],
            ['detalle'=>'Carpeta del proceso de ajustes a la red Geodésica Nacional (un original más dos copias).'],
            ['detalle'=>'Cd que contenga el plano georeferenciado en formato Autocad y los informes de ajuste de redes que incluyan los datos Rinex (3 copias).'],
            ['detalle'=>'Declaración Jurada efectuada ante Notario de Fe Pública, señalando que el terreno a georeferenciar no se encuentra en proceso judicial o administrativo y tampoco tiene limitación judicial, siendo el solicitante responsable ante la Ley de los perjuicios y daños que pudiera ocasionar con su declaración voluntaria.'],
            ['detalle'=>'En caso de contar con un plano topográfico georeferenciado aprobado anterior (de anterior propietario) que cumplió los requisitos, procedimientos respectivos debe ser adjunto el mismo En original o copia legalizada por la Secretaria Municipal de Gestión Territorial a objeto de su verificación técnico legal.'],
            ['detalle'=>'Formulario Unico de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 023), debidamente llenado y elevado a declaración jurada'],
            ['detalle'=>'Fotocopia del Testimonio de propiedad debidamente registrado y matriculado en Derecho Reales, con registro catastral, debidamente visado por la Secretaria Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Fotocopia del comprobante de pago de Impuesto a la Propiedad de Bienes Inmuebles y tasas por servicios del predio del último año, mismo que deberá estar VISADO por la Dirección de Asuntos Juridicos del G.A.M.O. o certificado negativo de la Unidad de Drenaje Urbano si el caso así lo requiera.'],
            ['detalle'=>'Fotocopia de cédula de identidad del o los propietarios; si el propietario es persona juridica, deberá presentar documentación del representante legal. En caso de que terceras personas y/o apoderado, deberá presentar copia legalizada de poder especifico y suficiente más fotocopia de la cedula de identidad del poderdante'],
            ['detalle'=>'Declaración Voluntaria ante Notario de Fe Pública señalando que el terreno a urbanizar no tiene limitación judicial y no se encuentra cuestionado que posteriormente pudiera resultar en una acción penal o civil, (la apropiación indebida o daño doloso), constituyéndose el solicitante responsable ante la Ley y las instancias ocasionales de los perjuicios y daños que pudiera ocasionar.'],
            ['detalle'=>'Certificado de Uso de Suelo Aprobado original o fotocopia legalizada por Dirección de Ordenamiento Territorial más comprobante de caja original o copia VISADA por la Dirección de Asuntos Juridicos del G.A.M.O'],
            ['detalle'=>'Plano Topográfico-Geo-referenciado Aprobado original o fotocopia legalizada por la Dirección de Ordenamiento Territorial más comprobante de caja por derecho de dicha aprobación original o fotocopia legalizada por la dirección juridica del GAMO'],
            ['detalle'=>'Planos de fraccionamiento completos debidamente acotados y emplazados en Plano Topográfico Georreferenciado aprobado, con determinación de aceras, ochaves anchos de via, nominación de avenidas y calles y otros datos técnicos, firmados por profesional arquitecto independiente (legalmente registrado por el C.A.B y visados por la CAO.) con seis (6) originales, seis (6) copias, destinados 2 al Usuario, 1 Archivo Técnico 1 DDRR, 1 Catastro Urbano, y 1 a ENDE. (Mismo que debe estar en ESCALA LEGIBLE todos los pianos deben ser presentados en papel bond.)'],
            ['detalle'=>'Planos de los sistemas sanitarios, agua potable y pluvial, planos de las estructuras complementarias, firmados por Profesional Ingeniero Civil independiente (Legalmente registrado en el S.I.B.) y visados por el colegio de ingenieros civiles de Oruro (C.I.C.O.), con seis (6) originales, seis (6) copias, destinados 2 al Usuario, 1 Archivo Técnico, 1 Catastro Urbano, 1 Drenaje Urbano y 1 al SeLA, (definir. la acometida de agua potable, la evacuación de las aguas pluviales y aguas servidas). (para predios iguales o mayores a 3000 m2'],
            ['detalle'=>'Memoria de Cálculo hidráulico del sistema sanitario, pluvial, agua potable y sus estructuras complementarias; con dos copias simples (fisico y digital). Debe incluir plano topográfico geo-referenciado, estudio de suelos, plano arquitectónico de la urbanización con coordenadas reales; plano sanitario, pluvial y de agua potable. (para predios iguales o mayores a 3000 m2)'],
            ['detalle'=>'Original de planos demostrativos de cada una de las áreas verdes, equipamientos y vias, debidamente identificadas más minuta de transferencia de las áreas cedidas a favor del Gobierno Autónomo Municipal de Oruro por el o los propietarios de la urbanización (fisico y digital). (conforme estudio técnico urbano'],
            ['detalle'=>'Estudio técnico urbano de respaldo de fraccionamiento y cesión de áreas públicas cumpliendo con las tramas urbanas de su entorno, elaborado por profesional arquitecto independiente (legalmente por el C.A.B.)'],
            ['detalle'=>'Plano Demostrativo de Fraccionamiento predial firmado por profesional independiente debidamente registrado en el colegio correspondiente (con dos copias).'],
            ['detalle'=>'Fotocopia del Testimonio de Propiedad que cuente con Folio Real en el registro de Derechos Reales del predio a ser fraccionado, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Minuta original de fraccionamiento del predio.'],
            ['detalle'=>'Acta notariada de conformidad de fraccionamiento y división del predio, debidamente firmada por todos los titulares y/o propietarios, que manifiesten su conformidad de ubicación, dimensiones y colindancias.'],
            ['detalle'=>'Fotocopias del Pago de impuestos a la propiedad de Bienes Inmuebles y Tasas y Patentes de la última gestión, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos.'],
            ['detalle'=>'Fotocopia de cédula de identidad de los titulares y beneficiarios de la división o fraccionamiento.'],
            ['detalle'=>'Planos Demostrativos de cada fraccionamiento a ser unificada, firmado por profesional independiente debidamente registrado en el colegio correspondiente. (Deberá adjuntar dos copias).'],
            ['detalle'=>'Plano de unificación firmado por el profesional independiente debidamente registrado en el colegio correspondiente. (Deberá adjuntar dos copias).'],
            ['detalle'=>'Testimonios de Propiedad que cuenten con Folios Reales registrados en Derechos Reales de cada uno de los predios a ser unificados, debidamente visados por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Escritura Pública de unificación del predio.'],
            ['detalle'=>'Fotocopias del Pago de Impuestos a la Propiedad de Bienes Inmuebles y Tasas y Patentes de las últimas dos (2) gestiones, debidamente visados por la Secretaría Municipal de Asuntos Jurídicos.'],
            ['detalle'=>'Fotocopia de cédula de identidad del titular de la unificación.'],
            ['detalle'=>'Formulario Unico de Solicitud de Trámite del Sistema de Ordenamiento Territorial y Desarrollo Urbano (FORM 001 ).'],
            ['detalle'=>'Fotocopia de Testimonio de propiedad, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Fotocopia del comprobante de pago del Impuesto a la Propiedad de Bienes Inmuebles y Tasas y Patentes del predio de los cinco (5) últimos años, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos.'],
            ['detalle'=>'Plano demostrativo original firmado por profesional independiente debidamente registrado en el colegio de profesionales correspondiente. (Con dos copias).'],
            ['detalle'=>'Comprobante de pago de valores y aranceles.'],
            ['detalle'=>'Fotocopia del Testimonio de propiedad debidamente registrado y matriculado en Derecho Reales, con registro catastral, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Fotocopia de cédula de identidad del propietario.'],
            ['detalle'=>'Fotocopia del comprobante de pago del Impuesto a la Propiedad de Bienes Inmuebles y Tasas y Patentes del predio de los tres (3) últimos años, debidamente visado por la Secretaría Municipal de Asuntos Jurídicos del Gobierno Autónomo Municipal de Oruro.'],
            ['detalle'=>'Plano Topográfico georeferenciado aprobado por el Gobierno Autónomo Municipal de Oruro, original o fotocopia debidamente legalizado por la Secretaría Municipal de Gestión Territorial. (salvo predios menores a 999,99 m2 los cuales deben presentar plano codificado por la Unidad de Catastro urbano en original).'],
            ['detalle'=>'Comprobante de pago de valores.'],
            ['detalle'=>'Testimonio de propiedad debidamente matriculado en el registro de Derechos Reales (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Pago de impuestos de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Pago por Tasas y Servicios de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Cédula de identidad del titular (fotocopia).'],
            ['detalle'=>'Testimonio de propiedad debidamente matriculado en el registro de Derechos Reales (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Pago de impuestos de la última gestión (fotocopia visada por la Secretaría Municipal de Asuntos Jurídicos).'],
            ['detalle'=>'Formulario de Registro para ingreso de tramite (Form 1)'],
            ['detalle'=>'Formulario de Registro Catastral debidamente llenado por profesional Arquitecto independiente legalmente registrado (Form 2)'],
            ['detalle'=>'Hoja Tecnica (Catastro Urbano)'],
            ['detalle'=>'Formulario Control de Documentos (de la Secretaria Municipal de Gestion Territorial) con firma y sello de ventanilla unica y del propietario (Form 3)'],
            ['detalle'=>'Cedula de Identidad del o los titulares (fotocopia)'],
            ['detalle'=>'Fotocopia revisada por Secretaria Municipal de Asuntos Juridicos de Testimonio de Propiedad debidamente registrado en DD.RR. con su folaio real (previo pago de valores conforme a Anexo A)'],
            ['detalle'=>'Fotocopia revisada por Secretaria Municipal de Asuntos juridicos de Pago de Impuestos y Tasas por Servicios de la ultima gestion'],
            ['detalle'=>'Original de Linea Nivel con una antigüedad maxima de dos años'],
            ['detalle'=>'Original de Plano Demostrativo Codificado, no mayor a cinco años'],
            ['detalle'=>'Planos Arquitectonicos de la construccion AS-BUILT (plano real de la obra ejecutada) en formato digital (CD) un original y dos copias en papel bond (de conformidad al procedimiento), elaborado por el profesional Arquitecto legalmente registrado, con numero de registro profesional. En caso de ampliacion de la construccion, cumplir lo establecido en el inciso C del articulo 10 del presente reglamento'],
            ['detalle'=>'Planos de Instalacion Sanitaria firmado por profesional Ingeniero Civil independiente, quien se constituye en responsable del mismo, debidamente registrado en el colegio correspondiente'],
            ['detalle'=>'Certificacion de Estabilidad Estructural de la construccion firmado por el profesional Ingeniero Civil independiente, quien se constituye en responsable del mismo, debidamente registrado en el colegio correspondiente, en cumplimiento a lo establecido en el inciso A del articulo 17 del presente reglamento'],
            ['detalle'=>'Certificacion de Instalacion Electrica firmado por el profesional Ingeniero Electrico independiente, quien se constituye en responsable del mismo, debidamente registrado en el colegio correspondiente, en cumplimiento a lo establecido en el inciso B del articulo 17 del presente reglamento'],
            ['detalle'=>'Valores Municipales previsto en la normativa municipal vigente'],

        ]);

    }
}
