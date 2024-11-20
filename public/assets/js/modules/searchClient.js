export default class searchClient{
    constructor(inputSearch,list){
        this.inputSearch = document.querySelector(inputSearch);
        this.list = document.querySelector(list);
    }

    searchClient(query){
        fetch(`http://localhost:8889/admin/schedule/searchClient/?query=${query}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro na requisição: " + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            this.createHtml(data);
        })
        .catch(error => {
            console.error("Erro:", error);
            dthis.list.innerHTML = "<p>Ocorreu um erro ao buscar os dados.</p>";
        });
    }

    createHtml(data){
        let html = `   <div class="client w-full flex items-center gap-4 border-b border-lightGray p-2">
                                <img src="/assets/images/avatar_default.png" alt="img-cliente" class="redondShapeImageCollaborator">
                                <div class="w-full flex justify-between items-center">
                                    <span>Nome: Cliente Padrão</span>
                                    <span>telefone:(xx)xxxxx-xxxx</span>
                                    <a href="/admin/schedule/store/client/default" class="bg-principal10 text-white text-sm p-2 rounded">Selecionar</a>
                                </div>
                            </div>`;

                            console.log(data)
        data.forEach(client => {
            html += `   <div class="client w-full flex items-center gap-4 border-b border-lightGray p-2">
                                <img src="${client.avatar}" alt="img-cliente" class="redondShapeImageCollaborator">
                                <div class="w-full flex justify-between items-center">
                                    <span>Nome: ${client.name}</span>
                                    <span>telefone:${client.phone}</span>
                                    <a href="/admin/schedule/store/client/${client.idClient}" class="bg-principal10 text-white text-sm p-2 rounded">Selecionar</a>
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
            } else {
                this.list.innerHTML = `<div class="client w-full flex items-center gap-4 border-b border-lightGray p-2">
                                <img src="/assets/images/avatar_default.png" alt="img-cliente" class="redondShapeImageCollaborator">
                                <div class="w-full flex justify-between items-center">
                                    <span>Nome: Cliente Padrão</span>
                                    <span>telefone:(xx)xxxxx-xxxx</span>
                                    <a href="/admin/schedule/store/client/default" class="bg-principal10 text-white text-sm p-2 rounded">Selecionar</a>
                                </div>
                            </div>`;
            }
        });
    }
}