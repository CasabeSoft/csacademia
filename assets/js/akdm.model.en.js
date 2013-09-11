akdm.model.PaymentPeriods = [
    {
        id: 1,
        name: "Monthly",
        periods: ["January", "February", "March", "April", "May", "June", "July", 
            "August", "September", "October", "November", "December"]
    },
    {
        id: 2,
        name: "Bimonthly",
        periods: ["January-February", "February-March", "March-April", "April-May", 
            "May-June", "June-July", "July-August", "August-September", 
            "September-October", "October-November", "November-December", 
            "December-January"]
    },
    {
        id: 3,
        name: "Quarterly",
        periods: ["January-March", "February-April", "March-May", "April-June", 
            "May-July", "June-August", "July-September", "August-October", 
            "September-November", "October-December", "November-January", 
            "December-February"]
    },
    {
        id: 4,
        name: "Every 4 months",
        periods: ["January-April", "February-May", "March-June", "April-July", 
            "May-August", "June-September", "July-October", "August-November", 
            "September-December", "October-January", "November-February", 
            "December-March"]
    },
    {
        id: 6,
        name: "Semiannual",
        periods: ["January-June", "February-July", "March-August", "April-September", 
            "May-October", "June-November", "July-December", "August-January", 
            "September-February", "October-March", "November-April", 
            "December-May"]
    },
    {
        id: 12,
        name: "Annual",
        periods: [(new Date().getFullYear() - 1) + "-" + new Date().getFullYear(),
            new Date().getFullYear() + "-" + (new Date().getFullYear() + 1)]
    }
];