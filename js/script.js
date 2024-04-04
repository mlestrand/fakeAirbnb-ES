
// javascript goes here

// points to src/ajax.php upon view button click 
// gives listing ID 
$('.view-Listing').on('click',function(){
    $.ajax({
        url:"src/ajax.php",
        method:"POST",
        data: {listingId: this.attr('id')},
        dataType: "json"
    })
    .done (function(data){
        json= json.parse(data);
        let pictureUrl = json.pictureUrl;
        let name = json.name;
        let neighborhoodId = json.neighborhoodId;
        let description = json.description;
        let roomTypeId = json.roomTypeId;
        let accomodates = json.accommodates;
        let price = json.price;
        let rating = json.rating;
    });
});
