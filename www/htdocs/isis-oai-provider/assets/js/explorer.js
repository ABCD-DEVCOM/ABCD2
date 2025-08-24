document.addEventListener('DOMContentLoaded', async () => {
    // --- FUNÇÃO DE TRADUÇÃO ---
    const t = (key) => {
        return key.split('.').reduce((obj, i) => obj && obj[i] ? obj[i] : null, translations) || key;
    };

    // --- ELEMENTOS DO DOM ---
    const sidebarLinks = document.querySelectorAll('.sidebar nav a');
    const paramsContainer = document.getElementById('params-form-container');
    const executeBtn = document.getElementById('execute-btn');
    const requestUrlDisplay = document.getElementById('request-url-display');
    const responseDisplay = document.getElementById('response-display');
    const baseUrlSpan = document.querySelector('.repo-url span');
    const copyUrlBtn = document.getElementById('copy-url-btn');
    const baseUrl = baseUrlSpan ? baseUrlSpan.textContent.trim() : '';
    const langSelect = document.getElementById('lang-select'); // NOVO: Captura o dropdown

    // ... (O restante do código, como as funções de busca e manipulação de formulário, permanece o mesmo) ...
    let availableSets = [];
    let availableFormats = [];
    const formCache = {};
    let currentVerb = null;

    const fetchOaiData = async (verb) => {
        try {
            const response = await fetch(`${baseUrl}?verb=${verb}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const xmlText = await response.text();
            const parser = new DOMParser();
            return parser.parseFromString(xmlText, "text/xml");
        } catch (error) {
            console.error(`Falha ao buscar ${verb}:`, error);
            return null;
        }
    };

    const loadDynamicData = async () => {
        const setsXml = await fetchOaiData('ListSets');
        if (setsXml) {
            availableSets = Array.from(setsXml.getElementsByTagName('setSpec')).map(el => el.textContent).sort();
        }
        const formatsXml = await fetchOaiData('ListMetadataFormats');
        if (formatsXml) {
            availableFormats = Array.from(formatsXml.getElementsByTagName('metadataPrefix')).map(el => el.textContent).sort();
        }
    };

    const paramDefinitions = {
        'Identify': [],
        'ListMetadataFormats': ['identifier'],
        'ListSets': ['resumptionToken'],
        'ListIdentifiers': ['metadataPrefix', 'from', 'until', 'set', 'resumptionToken'],
        'ListRecords': ['metadataPrefix', 'from', 'until', 'set', 'resumptionToken'],
        'GetRecord': ['set', 'identifier', 'metadataPrefix']
    };

    const updateCache = () => {
        paramsContainer.querySelectorAll('input, select').forEach(el => {
            if (el.value && el.name) {
                formCache[el.name] = el.value;
            }
        });
    };

    const displayParamsForVerb = (verb) => {
        currentVerb = verb;
        paramsContainer.innerHTML = '';
        const params = paramDefinitions[verb] || [];
        if (params.length > 0) {
            params.forEach(param => {
                const row = document.createElement('div');
                row.className = 'param-row';
                const label = document.createElement('label');
                label.setAttribute('for', `param-${param}`);
                label.textContent = param.charAt(0).toUpperCase() + param.slice(1);
                row.appendChild(label);
                let input;
                if (param === 'set' && availableSets.length > 0) {
                    input = document.createElement('select');
                    availableSets.forEach(set => {
                        const option = document.createElement('option');
                        option.value = set;
                        option.textContent = set;
                        input.appendChild(option);
                    });
                } else if (param === 'metadataPrefix' && availableFormats.length > 0) {
                    input = document.createElement('select');
                    availableFormats.forEach(format => {
                        const option = document.createElement('option');
                        option.value = format;
                        option.textContent = format;
                        input.appendChild(option);
                    });
                } else if (param === 'from' || param === 'until') {
                    input = document.createElement('input');
                    input.type = 'date';
                } else {
                    input = document.createElement('input');
                    input.type = 'text';
                    input.placeholder = t(`placeholders.${param}`) || '';
                }
                input.id = `param-${param}`;
                input.name = param;
                if (formCache[param]) {
                    input.value = formCache[param];
                }
                row.appendChild(input);
                paramsContainer.appendChild(row);
            });
        } else {
            paramsContainer.innerHTML = `<p>${t('noParams')}</p>`;
        }
        executeBtn.style.display = 'inline-block';
        updateRequestUrl();
    };

    const buildApiUrl = () => {
        // ... (esta função não precisa de alterações)
        if (!currentVerb) return baseUrl;
        updateCache();
        const params = new URLSearchParams();
        params.append('verb', currentVerb);
        if (currentVerb === 'GetRecord') {
            const set = formCache['set'] || '';
            const id = document.getElementById('param-identifier')?.value || '';
            const prefix = formCache['metadataPrefix'] || '';
            if (prefix) params.append('metadataPrefix', prefix);
            if (set && id) {
                const fullIdentifier = `oai:${oaiConfig.idDomain}:${oaiConfig.idPrefix}-${set}-${id}`;
                params.append('identifier', fullIdentifier);
            }
        } else {
            paramsContainer.querySelectorAll('input, select').forEach(input => {
                if (input.value) {
                    params.append(input.name, input.value);
                }
            });
        }
        const displayUrl = new URL(baseUrl);
        params.forEach((value, key) => {
            displayUrl.searchParams.append(key, value);
        });
        params.append('lang', currentLang);
        return {
            requestUrl: `${baseUrl}?${params.toString()}`,
            displayUrl: decodeURIComponent(displayUrl.toString())
        };
    };

    const updateRequestUrl = () => {
        const { displayUrl } = buildApiUrl();
        requestUrlDisplay.textContent = displayUrl;
    };

    const executeRequest = async () => {
        // ... (esta função não precisa de alterações)
        const { requestUrl } = buildApiUrl();
        updateRequestUrl();
        responseDisplay.textContent = t('loading');
        try {
            const response = await fetch(requestUrl);
            const xmlText = await response.text();
            if (!response.ok) {
                const errorMatch = xmlText.match(/<error code=".*?">(.*?)<\/error>/);
                const errorMessage = errorMatch ? errorMatch[1] : `Erro HTTP: ${response.status}`;
                throw new Error(errorMessage);
            }
            responseDisplay.textContent = xmlText;
            Prism.highlightAll();
        } catch (error) {
            responseDisplay.textContent = `${t('requestFail')}\n${error.message}`;
        }
    };

    // --- EVENT LISTENERS ---
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            updateCache();
            sidebarLinks.forEach(l => l.classList.remove('active'));
            e.target.classList.add('active');
            const verb = e.target.dataset.verb;
            displayParamsForVerb(verb);
        });
    });

    executeBtn.addEventListener('click', executeRequest);
    paramsContainer.addEventListener('input', updateRequestUrl);

    // NOVO: Event listener para o dropdown de idiomas
    if (langSelect) {
        langSelect.addEventListener('change', () => {
            const newLang = langSelect.value;
            // Recarrega a página com o novo parâmetro de idioma
            window.location.href = `?lang=${newLang}`;
        });
    }

    copyUrlBtn.addEventListener('click', () => {
        const urlToCopy = requestUrlDisplay.textContent;
        if (navigator.clipboard && urlToCopy) {
            navigator.clipboard.writeText(urlToCopy).then(() => {
                const originalText = copyUrlBtn.textContent;
                copyUrlBtn.textContent = t('copied');
                setTimeout(() => {
                    copyUrlBtn.textContent = originalText;
                }, 2000);
            }).catch(err => {
                console.error('Falha ao copiar a URL: ', err);
            });
        }
    });

    // --- INICIALIZAÇÃO ---
    await loadDynamicData();
    if (sidebarLinks.length > 0) {
        sidebarLinks[0].click();
    }
});