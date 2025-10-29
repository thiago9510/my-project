class DtSidebar extends HTMLElement {
    constructor() {
        super()
        this.attachShadow({ mode: "open" }) //Cria o Shadow Dom do Elemento
        this.shadowRoot.innerHTML = `
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
            <style>               
                .sidebar {
                    height: 100vh;
                    position: relative;
                    justify-content: space-between;    
                    width: 60px;
                    transition: width 0.3s ease;
                }

                .side-items {
                    padding: 10px;                    
                }

                .side-item {
                    padding: 10px;
                    border-radius: 8px;
                    transition: background-color 0.3s ease;
                    cursor: pointer;                    
                }

                .side-item.active {
                    background-color: var(--color-primary, #2563eb);
                    color: white;
                    gap: 14px;         
                }

                .side-item:hover:not(.active) {
                    background-color: var(--color-primary-hover, #e3e9f7);                    
                }

                .side-item a {
                    text-decoration: none;
                    color: #0a0a0a;
                    display: flex;
                    align-items: center;
                }

                .side-item.active a {
                    color: #e3e9f7;
                }

                .side-item a i {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 20px;
                    height: 20px;
                }

                .item-description {
                    transform: translateX(-10px);
                    transition: all 0.3s ease;
                    width: 0px;
                    overflow: hidden;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                    font-size: 14px;
                    height: 0px;
                }

                .sidebar.open-sidebar {
                    width: 250px;    
                }

                .sidebar.open-sidebar .item-description {
                    min-width: 150px;
                    height: auto;
                }

                .sidebar.open-sidebar .side-item a {
                    justify-content: flex-start;
                    gap: 14px;
                }
            </style>

            <div class="sidebar open-sidebar">                
                <div class="side-items">
                    <div class="side-item">                       
                        <a id="menu" class="menu-toggle">                            
                            <i class="fa-solid fa-bars"></i>                           
                            <span class="item-description">Menu</span>
                        </a>
                    </div>
                    <!-- Os demais itens serão inseridos dinamicamente -->
                </div>
            </div>        
        `
    }

    connectedCallback() {
        // Defina os itens que deseja exibir dinamicamente
        const menuItems = [
            { label: "Home", icon: "fa-house", href: "/" },
            { label: "Cart", icon: "fa-cart-shopping", href: "/cart" },
            { label: "Store", icon: "fa-store", href: "/store" },
            { label: "Preson", icon: "fa-solid fa-user", href: "/persons" }
        ]

        this.render(menuItems)
        this.setupEvents()
        this.updateActiveByRoute(window.location.pathname)

        // Atualiza o item ativo ao mudar o hash
        window.addEventListener("popstate", () => {
            this.updateActiveByRoute(window.location.pathname)
        })
    }

    render(items) {
        const container = this.shadowRoot.querySelector('.side-items')
        const allItems = container.querySelectorAll('.side-item')

        // Mantém apenas o primeiro item (botão menu), remove os outros (faz um reset do menu)
        allItems.forEach((item, index) => {
            if (index !== 0) item.remove()
        })

        items.forEach(item => {
            const div = document.createElement('div')
            div.classList.add('side-item')
            div.innerHTML = `
                <a href="${item.href}">
                    <i class="fa-solid ${item.icon}"></i>
                    <span class="item-description">${item.label}</span>
                </a>
            `
            container.appendChild(div)
        })
    }

    setupEvents() {
        //methodo para validar os eventos de click no menu
        const sidebar = this.shadowRoot.querySelector('.sidebar')
        const menuButton = this.shadowRoot.querySelector('#menu')

        // Expande/colapsa o menu só se clicar no botão
        menuButton.addEventListener('click', (e) => {
            e.stopPropagation()
            sidebar.classList.toggle('open-sidebar')
        })
    }

    updateActiveByRoute(path) {
        const items = this.shadowRoot.querySelectorAll(".side-item")
        items.forEach(item => {
            const link = item.querySelector("a")
            if (link && link.getAttribute("href") === path) {
                item.classList.add("active")
            } else {
                item.classList.remove("active")
            }
        })
    }

}

customElements.define('dt-sidebar', DtSidebar);
