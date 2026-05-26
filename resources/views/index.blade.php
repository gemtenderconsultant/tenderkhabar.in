@extends('layouts.app')
@section('content')
<style>
    .index-card-view-all a{
        text-decoration: none;
        color: var(--primary-blue);
}
</style>
<!-- HERO SECTION -->
<section class="index-hero">
    <div class="index-container">
        <div class="index-hero-content">
            <h1>Discover Your Next <br><span class="index-text-gradient">Multi-Million Project.</span></h1>
            <p>Access the most comprehensive database of government tenders, GeM opportunities, and procurement analytics in India.</p>
            
            <div class="index-search-glass">
                <div class="index-search-tabs">
                    <button class="index-s-tab active" data-action="{{ route('searchtenders') }}" onclick="switchTab(this)">Tender</button>
                    <button class="index-s-tab" data-action="{{ route('searchresults') }}" onclick="switchTab(this)">Results</button>
                </div>
                <form action="{{ route('searchtenders') }}" style="display: contents;"class="form-search d-flex align-items-stretch mt-3" id="home_searchbar_new" data-aos="fade-up" data-aos-delay="200">
                <div class="index-search-main">
                    <input type="text" name="searchbox" id="searchbox" placeholder="Keywords (e.g. Highways, Solar, IT Services)">
                    <button class="index-btn-search"><i data-lucide="search" size="18"></i> SEARCH</button>
                </div>
                </form>
                <button class="index-adv-search-btn advan-search-btn" id="index-openAdv"><i data-lucide="settings-2" size="16"></i> Advanced Search</button>
            </div>
        </div>
    </div>
</section>

<!-- BENTO DIRECTORIES SECTION -->
<section class="index-dir-section index-container">
    <div class="index-section-header">
        <h2><span class="index-text-gradient">Market Intelligence</span> Directories</h2>
        <p>Browse through structured data covering all states, categories, and top issuing authorities.</p>
    </div>
    <div class="index-dir-grid">
        <div class="index-dir-card index-card-state">
            <div class="index-dir-head"><i data-lucide="map-pin" size="20"></i><h4>By State</h4></div>
            <ul class="index-dir-list" id="state-cards">
                <li><a href="#">Maharashtra <span class="index-count">4,502</span></a></li>
                <li><a href="#">Uttar Pradesh <span class="index-count">3,821</span></a></li>
                <li><a href="#">Gujarat <span class="index-count">2,910</span></a></li>
                <li><a href="#">Tamil Nadu <span class="index-count">2,100</span></a></li>
                <li><a href="#">Karnataka <span class="index-count">1,850</span></a></li>
                <li><a href="#">Rajasthan <span class="index-count">1,620</span></a></li>
            </ul>
            <div id="state-view-all" class="index-card-view-all"></div>
        </div>
        <div class="index-dir-card index-card-category">
            <div class="index-dir-head"><i data-lucide="layout-grid" size="20"></i><h4>By Category</h4></div>
            <ul class="index-dir-list" id="category-cards">
            </ul>
            <div id="category-view-all" class="index-card-view-all"></div>
        </div>
        <div class="index-dir-card index-card-authority">
            <div class="index-dir-head"><i data-lucide="building-2" size="20"></i><h4>By Authority</h4></div>
            <ul class="index-dir-list" id="authority-cards">
                <li><a href="#">Indian Railways <span class="index-count">850</span></a></li>
                <li><a href="#">NHAI Roads <span class="index-count">420</span></a></li>
                <li><a href="#">Military Services <span class="index-count">310</span></a></li>
                <li><a href="#">CPWD Central <span class="index-count">1,200</span></a></li>
                <li><a href="#">Municipal Corps <span class="index-count">940</span></a></li>
                <li><a href="#">Defence Portals <span class="index-count">520</span></a></li>
            </ul>
            <div id="authority-view-all" class="index-card-view-all"></div>
        </div>
    </div>
</section>

<!-- PREMIUM SERVICES CAROUSEL -->
<section class="index-section-padding">
    <div class="index-container">
        <div class="index-section-header">
            <h2>Our <span class="index-text-gradient">Premium Services</span></h2>
            <p>End-to-end procurement solutions to multiply your chances of winning high-value contracts.</p>
        </div>
        <div class="swiper serviceSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Registration.png"
                            class="index-svc-img" alt="Seller Registration">
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="file-spreadsheet" size="28"></i></div>
                            <h4>Seller Registration</h4>
                            <p>Hassle-free GeM registration with complete document support, profile setup, and
                                onboarding assistance to start selling quickly.</p>
                            <button class="index-btn index-btn-login" style="width: 100%;">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Assesment.png"
                            class="index-svc-img" alt="Vendor Assessment">
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="trending-up" size="28"></i></div>
                            <h4>Vendor Assessment</h4>
                            <p>End-to-end support for vendor assessment including document evaluation, compliance
                                guidance and preparation for approval.</p>
                            <button class="index-btn index-btn-login" style="width: 100%;">Get Intel</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Exemption.png"
                            class="index-svc-img" alt="Vendor Assessment Exemption">
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="users" size="28"></i></div>
                            <h4>Vendor Assessment Exemption</h4>
                            <p>Assistance in claiming exemption based on eligibility criteria like BIS license, drug
                                license, or other government approvals.</p>
                            <button class="index-btn index-btn-login" style="width: 100%;">Find Partners</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Approval.png"
                            class="index-svc-img" alt="OEM Panel & Brand Approval">
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="award" size="28"></i></div>
                            <h4>OEM Panel & Brand Approval</h4>
                            <p>Get your brand registered and access OEM benefits on GeM with support for trademark
                                or undertaking-based approvals.
                            </p>
                            <button class="index-btn index-btn-login" style="width: 100%;">View Service</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Products3.png"
                            class="index-svc-img" alt="Product & Service Cataloguing" >
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="layout-grid" size="28"></i></div>
                            <h4>Product & Service Cataloguing</h4>
                            <p>Professional catalog creation as per GeM guidelines, ensuring accurate listings and
                                compliance with category requirements.
                            </p>
                            <button class="index-btn index-btn-login" style="width: 100%;">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Bidding3.png"
                            class="index-svc-img" alt="Tender Bidding">
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="gavel" size="28"></i></div>
                            <h4>Tender Bidding</h4>
                            <p>Expert assistance in bidding process including document guidance, submission and
                                complete tender management support.
                            </p>
                            <button class="index-btn index-btn-login" style="width: 100%;">Learn More</button>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="index-service-card">
                        <img src="/assets/images/Order1.png"
                            class="index-svc-img" alt="Order Processing">
                        <div class="index-svc-content">
                            <div class="index-svc-icon"><i data-lucide="package-check" size="28"></i></div>
                            <h4>Order Processing</h4>
                            <p>
                                Smooth post-order handling with support for invoicing, compliance, payment
                                follow-ups, and required documentation.
                            </p>
                            <button class="index-btn index-btn-login" style="width: 100%;">Learn More</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="swiper-pagination" style="bottom: 0;"></div>
        </div>
    </div>
</section>

<!-- ADVANCED SEARCH MODAL -->
<div class="index-modal-overlay" id="index-advModal">
    <div class="index-modal-box">
        <div style="display:flex; justify-content: space-between; align-items: center;">
            <h3>Advanced Search</h3>
            <button id="index-closeAdv" style="border:none; background:#f1f5f9; padding:8px; border-radius:50%; cursor:pointer;"><i data-lucide="x" size="20"></i></button>
        </div>
        <form class="advance-search-form index-adv-grid" method="GET" action="{{ route('postadvancesearch')}}">
            <div>
            <select multiple="multiple" class="stateid" name="state[]" id="stateid" name="state_id">
                <option>Select State / Region</option>
            </select>
            </div>
            <div>
                <select class="city" multiple="multiple" name="city[]"></select>
            </div>
            <div>
            <select><option>Select Work Category</option></select>
            </div>
            <div>
            <input type="text" id="ntid"  name="ntid" placeholder="Tender ID / Ref No.">
            </div>
            <div>
                <select multiple="multiple" class="agencyid" name="state[]" id="agencyid" name="agencyid">
                    <option>Select Agency</option>
            </select>
            </div>
            <div>
                <input type="text" placeholder="Keywords" name="keyword" value="" class="index-full">
            </div>
            <div class="index-full" style="display: flex; gap: 10px;">
                <button type="submit" class="index-btn index-btn-reg" style="flex: 2;">EXECUTE SEARCH</button>
                <button type="reset" class="index-btn index-btn-login" style="flex: 1;">CLEAR</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<!-- FOOTER -->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('body').on('click', '.advan-search-btn', function () {
        $.ajax({
            url: "/advan-search-btn",
            type: "GET",
            success: function (response) {
                if (response.status == "success") {
                    let options = '<option>Select State / Region</option>';

                    $.each(response.data, function (key, value) {
                        options += `<option value="${value.id}">${value.name}</option>`;
                    });

                    $('#stateid').html(options);
                    $('#stateid').select2({
                            width: "100%",
                            placeholder: "Search & Select State",
                            // allowClear: true,
                            dropdownParent: $('#index-advModal') // 🔥 MUST
                        });
                    }
                    // 🔹 AGENCY DROPDOWN
                let agencyOptions = '<option value="">Select Agency</option>';
                $.each(response.agency, function (key, value) {
                    agencyOptions += `<option value="${value.agencyid}">${value.agencyname}</option>`;
                });

                $('#agencyid').html(agencyOptions).select2({
                    width: "100%",
                    placeholder: "Search & Select Agency",
                    dropdownParent: $('#index-advModal')
                });
            }
        });
    });

$(document).ready(function() {
  var _token = $('meta[name="csrf-token"]').attr('content');

  $('.city').select2({
    width:"100%",
    placeholder:"Select City"
  });
  $('body').on('change ','.stateid', function () {
    var selectedState = new Array();
    var selectedState = $(this).val();
    $.ajax({
        'type': 'POST',
        'url': "{{ route('city-filter-select2-advance') }}",
        'data': {'data':selectedState,'_token':_token},
        'cache': false,
        'success': function (response){
          if(response.success == true){
           $(".city").html(response.data);
            // 🔥 re-init with modal fix
            $(".city").select2({
                width: "100%",
                placeholder: "Select City",
                dropdownParent: $('#index-advModal')
            });
          } 
        }
    });
  });
});
</script>
<script type="text/javascript">
    $('.searchbox').on('click', function () {

    // active class handle
    $('.searchbox').removeClass('active');
    $(this).addClass('active');

    // form action change
    let newAction = $(this).data('action');
    $('#home_searchbar_new').attr('action', newAction);

    });
    var sr_length =  $(".searchbox_input").length;
    if(sr_length > 0){
        $.widget("app.autocomplete", $.ui.autocomplete, {
            // Which class get's applied to matched text in the menu items.
            options: {
                highlightClass: "ui-state-highlight"
            },
            _renderItem: function (ul, item) {
               var re = new RegExp("(" + this.term + ")", "gi"),
                        cls = this.options.highlightClass,
                        template = "<span class='" + cls + "'>$1</span>",
                        label = item.label.replace(re, template),
                        $li = jQuery("<li/>").appendTo(ul);
                jQuery("<a/>").attr("href", "#")
                        .html(label)
                        .appendTo($li);
                return $li;
            }
        });
    }

    lucide.createIcons();

    function switchTab(btn) {
        document.querySelectorAll('.index-s-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        // form action change
        let action = btn.getAttribute('data-action');
        document.getElementById('home_searchbar_new').setAttribute('action', action);
    }
    // Modal Logic
    const modal = document.getElementById('index-advModal');
    document.getElementById('index-openAdv').onclick = () => modal.classList.add('active');
    document.getElementById('index-closeAdv').onclick = () => modal.classList.remove('active');

    // Swiper
    new Swiper(".serviceSwiper", {
        slidesPerView: 1, spaceBetween: 20, loop: true, autoplay: { delay: 4000 },
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });

    const stateData = [
        { name: "Maharashtra", count: 4502 },
        { name: "Uttar Pradesh", count: 3821 },
        { name: "Gujarat", count: 2910 },
        { name: "Tamil Nadu", count: 2100 },
        { name: "Karnataka", count: 1850 },
        { name: "Rajasthan", count: 1620}
    ];

    const categoryData = [
        { name: "Construction", count: 12400 },
        { name: "Healthcare", count: 4200 },
        { name: "IT Services", count: 2100 },
        { name: "Transport", count: 3400 },
        { name: "Electrical Goods", count: 14000 },
        { name: "Textiles", count: 850 }
    ];
    const authorityData = [
        { name: "NHAI", count: 420 },
        { name: "CPWD", count: 1200 },
        { name: "BHEL", count: 310 },
        { name: "ONGC", count: 940 },
        { name: "Municipal Corps", count: 940 },
        { name: "Defence Portals", count: 520 }
    ];

// MAIN FUNCTION
function renderCards( containerId,viewAllContainerId,dataList,limit = 5,viewAllText = 'View All') {
    const container = document.getElementById(containerId);
    const viewAllContainer = document.getElementById(viewAllContainerId);
    container.innerHTML = '';
    viewAllContainer.innerHTML = '';
    const visibleItems = dataList.slice(0, limit);
    visibleItems.forEach(item => {

        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = "javascript:void(0)";
        a.innerHTML = ` ${item.name}
            <span class="index-count">
                ${item.count.toLocaleString()}
            </span> `;
        // redirect logic

        a.addEventListener('click', () => {
            let url = '';
            if (containerId === 'state-cards') {
                url = "{{ url('stateresult') }}/"
                    + encodeURIComponent(item.name);
            }
            else if (containerId === 'category-cards') {
                url = "{{ url('categoryresult') }}/"
                    + encodeURIComponent(item.name);
            }
            else if (containerId === 'authority-cards') {
             url = "{{ url('authoritiesresult') }}/"
                    + encodeURIComponent(item.name);
            }
            if (url) {
                window.location.href = url;
            }
        });

        li.appendChild(a);
        container.appendChild(li);

    });

    // VIEW ALL LINK (OUTSIDE UL)
    const viewAllA =
        document.createElement('a');

    viewAllA.href =
        "javascript:void(0)";

    viewAllA.innerHTML = `
        ${viewAllText}
        <i data-lucide="arrow-right" size="16"></i>`;

    viewAllA.addEventListener('click', () => {

        let url = '';

        if (containerId === 'state-cards') {
            url =  "{{ route('state') }}";
        }

        else if (containerId === 'category-cards') {
            url = "{{ route('category') }}";
        }
        else if (containerId === 'authority-cards') {
            url = "{{ route('authorities') }}";
        }
        if (url) {
            window.location.href = url;
        }
    });
    viewAllContainer.appendChild(viewAllA);

}

// Initial rendering
renderCards('state-cards','state-view-all',stateData,6,'View 36 States & UTs');

renderCards('category-cards','category-view-all',categoryData,6,'Explore 150+ Categories');

renderCards('authority-cards','authority-view-all',authorityData,6,'View 45,000+ Authorities');

</script>
@endsection