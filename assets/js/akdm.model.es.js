akdm.model.PaymentPeriods = [
    {
        id: 1,
        name: "Mensual",
        periods: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
    },
    {
        id: 2,
        name: "Bimenstral",
        periods: ["Enero-Febrero", "Febrero-Marzo", "Marzo-Abril", "Abril-Mayo", 
            "Mayo-Junio", "Junio-Julio", "Julio-Agosto", "Agosto-Septiembre", 
            "Septiembre-Octubre", "Octubre-Noviembre", "Noviembre-Diciembre", 
            "Diciembre-Enero"]
    },
    {
        id: 3,
        name: "Trimestral",
        periods: ["Enero-Marzo", "Febrero-Abril", "Marzo-Mayo", "Abril-Junio", 
            "Mayo-Julio", "Junio-Agosto", "Julio-Septiembre", "Agosto-Octubre", 
            "Septiembre-Noviembre", "Octubre-Diciembre", "Noviembre-Enero", 
            "Diciembre-Febrero"]
    },
    {
        id: 4,
        name: "Cuatrimestral",
        periods: ["Enero-Abril", "Febrero-Mayo", "Marzo-Junio", "Abril-Julio", 
            "Mayo-Agosto", "Junio-Septiembre", "Julio-Octubre", "Agosto-Noviembre", 
            "Septiembre-Diciembre", "Octubre-Enero", "Noviembre-Febrero", 
            "Diciembre-Marzo"]
    },
    {
        id: 6,
        name: "Semestral",
        periods: ["Enero-Junio", "Febrero-Julio", "Marzo-Agosto", "Abril-Septiembre", 
            "Mayo-Octubre", "Junio-Noviembre", "Julio-Diciembre", "Agosto-Enero", 
            "Septiembre-Febrero", "Octubre-Marzo", "Noviembre-Abril", 
            "Diciembre-Mayo"]
    },
    {
        id: 12,
        name: "Anual",
        periods: [(new Date().getFullYear() - 1) + "-" + new Date().getFullYear(),
            new Date().getFullYear() + "-" + (new Date().getFullYear() + 1)]
    }
];