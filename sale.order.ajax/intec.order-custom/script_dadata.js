// Замените на свой API-ключ
const token = "5150c39a7f5eff6febe9c7593fa8329a78844f4d";

$("#soa-property-1").suggestions({
    token: token,
    type: "NAME"
});
$("#soa-property-2").suggestions({
    token: token,
    type: "EMAIL"
});

$("#soa-property-7").suggestions({
    token: token,
    type: "ADDRESS",
    constraints: [
        // Москва
        {
            locations: { region: 'Москва' },
        },
        // Московская область
        {
            locations: { kladr_id: '50' },
        }
    ]
});
