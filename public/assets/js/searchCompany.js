export default class searchCompany{
    constructor(inputSearch,list){
        this.inputSearch = document.querySelector(inputSearch);
        this.list = document.querySelector(list);
    }

    searchClient(query){
        fetch(`http://localhost:8889/company/searchCompany/?query=${query}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro na requisição: " + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if(data.length == 0){
                this.list.innerHTML = `<div class="w-full  text-grayInput flex flex-col gap-2 items-center justify-center p-12" >
                        <i class='bx bxs-info-circle text-4xl'></i>
                        <span class="font-Urbanist font-semibold text-xl">Nenhuma empresa encontrada!</span>
                    </div>`;
            }else{
                this.createHtml(data);
            }

        })
        .catch(error => {
            console.error("Erro:", error);
            this.list.innerHTML = "<p>Ocorreu um erro ao buscar os dados.</p>";
        });
    }

    createHtml(data){
        let html = ``;

        console.log(data)
        data.forEach(company => {
            html += `   <div class="  border border-lightGray p-4  flex flex-col gap-4 rounded" style="max-width:30%;">
                            <div class="w-full relative">
                                <img src="http://localhost:8889/${company.logo}" alt="" class="w-full rounded-md" style="max-height: 200px;">
                                <img src="http://localhost:8889/${company.logo}" alt="" class="w-full rounded-md redondShapeImageCollaborator absolute bottom-0 left-0 z-10" style="width:4rem; height:4rem;">
                            </div>
                            
                            <div class="w-full h-full flex flex-col gap-4 px-4 items-start justify-start">
                                <a href="http://localhost:8889/company/show/${company.idCompany}" class="font-Urbanist font-semibold text-2xl flex items-center gap-4">${company.name}<span class="text-base text-yellow font-Poppins font-semibold" ><i class='bx bxs-star text-xl' style='color:#fbec5d'  ></i>4.5</span></a>
                                <h3 class="w-full font-Poppins font-normal text-sm ">${company.road}, numero: ${company.number}, ${company.district} - ${company.city} - ${company.state}</h3>
                              
                                <a href="http://localhost:8889/company/show/${company.idCompany}" class="w-2/4 p-2 bg-principal10 text-sm text-white text-center font-Urbanist font-normal rounded cursor-pointer hover:underline">Ver mais</a>
                            </div>
                        </div>`;
        });
        this.list.innerHTML = html;
    }

    init(){
        console.log(this.inputSearch)
        console.log(this.list)

        this.inputSearch.addEventListener("keyup", (e) => {
        console.log(e.target.value)

            let query = e.target.value;

            if (query.length >= 3) { 
                this.searchClient(query);
            } 

            if(query.length == 0){
                window.location.reload()
            }
        });
    }
}