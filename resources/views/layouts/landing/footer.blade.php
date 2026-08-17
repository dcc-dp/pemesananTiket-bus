<footer id="footer" class="footer">
    <div class="footer-main" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6 footer-widget footer-about">
                    <h3 class="widget-title" style="color: #ffffff;">Tentang BusTicket</h3>
                    <span style="font-size: 1.4rem; font-weight: 800; color: #ffffff;">
                        <i class="fas fa-bus" style="color: #7FA8E0;"></i> BusTicket
                    </span>
                    <p style="color: rgba(255,255,255,0.75); margin-top: 0.8rem;">
                        Aplikasi pemesanan tiket bus online. Pilih jadwal, pilih kursi, bayar, dan dapatkan tiket digital dengan mudah.
                    </p>
                    <div class="footer-social">
                        <ul>
                            <li><a href="#" aria-label="Facebook" style="color: rgba(255,255,255,0.75);"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" aria-label="Instagram" style="color: rgba(255,255,255,0.75);"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" aria-label="Twitter" style="color: rgba(255,255,255,0.75);"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0">
                    <h3 class="widget-title" style="color: #ffffff;">Hubungi Kami</h3>
                    <div class="working-hours">
                        <ul class="list-arrow" style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: rgba(255,255,255,0.75); font-size: 0.9rem; line-height: 1.6; display: flex; align-items: flex-start; gap: 0.5rem;">
                                <i class="fas fa-map-marker-alt" style="color: rgba(255,255,255,0.4); margin-top: 0.2rem;"></i>
                                <span>Jl. Perintis Kemerdekaan KM 11, Makassar, Sulawesi Selatan</span>
                            </li>
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: rgba(255,255,255,0.75); font-size: 0.9rem; line-height: 1.6; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-phone-alt" style="color: rgba(255,255,255,0.4);"></i>
                                <a href="tel:04111234567" style="color: rgba(255,255,255,0.75); text-decoration: none;">(0411) 123-4567</a>
                            </li>
                            <li style="padding: 0.5rem 0; border-bottom: none; color: rgba(255,255,255,0.75); font-size: 0.9rem; line-height: 1.6; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-envelope" style="color: rgba(255,255,255,0.4);"></i>
                                <a href="mailto:cs@busticket.test" style="color: rgba(255,255,255,0.75); text-decoration: none;">cs@busticket.test</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 footer-widget mt-5 mt-md-0">
                    <h3 class="widget-title" style="color: #ffffff;">Layanan</h3>
                    <div class="working-hours" style="color: rgba(255,255,255,0.75);">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="padding: 0.4rem 0;"><a href="{{ route('tiket.search') }}" style="color: rgba(255,255,255,0.75); text-decoration: none;">Cari Tiket Bus</a></li>
                            @if (Session('cek'))
                                <li style="padding: 0.4rem 0;"><a href="{{ route('customer.bookings') }}" style="color: rgba(255,255,255,0.75); text-decoration: none;">Booking Saya</a></li>
                                <li style="padding: 0.4rem 0;"><a href="{{ route('customer.tickets') }}" style="color: rgba(255,255,255,0.75); text-decoration: none;">Tiket Saya</a></li>
                            @endif
                            <li style="padding: 0.4rem 0;"><a href="{{ route('register') }}" style="color: rgba(255,255,255,0.75); text-decoration: none;">Daftar Akun</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright" style="background: linear-gradient(135deg, #0B1F3A 0%, #123E73 50%, #1E5AA8 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <div class="copyright-info">
                        <span style="color: rgba(255,255,255,0.5); font-size: 0.85rem;">
                            Copyright &copy; <script>document.write(new Date().getFullYear())</script> BusTicket. All rights reserved.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>