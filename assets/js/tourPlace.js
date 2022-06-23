function TourPlace() {
    let tourRectangleNames = document.querySelectorAll('.tour-rectangle__place--name')
    
    tourRectangleNames.forEach(tourRectangleName => {
        let tourRectangleProvince = tourRectangleName.nextElementSibling
        let tourRectangleContent = tourRectangleName.closest('.tour-rectangle__place--content')
        let tourRectangleImg = tourRectangleContent.previousElementSibling
    
        tourRectangleImg.style.height = 0.7 * tourRectangleImg.clientWidth + 'px'
        tourRectangleName.style.fontSize = 0.07 * tourRectangleContent.clientWidth + 'px'
        tourRectangleProvince.style.fontSize = 0.04 * tourRectangleContent.clientWidth + 'px'
    })
    
    let tourSquareImgs = document.querySelectorAll('.tour-square__place--img')
    
    tourSquareImgs.forEach(tourSquareImg => tourSquareImg.style.height = tourSquareImg.clientWidth + 'px')
    
    let tourCitiesPlaceImgs = document.querySelectorAll('.tour-cities__place--img')

    tourCitiesPlaceImgs.forEach(tourCitiesPlaceImg => (tourCitiesPlaceImg.style.height = tourCitiesPlaceImg.clientWidth + 'px'))
}

export default TourPlace;