******************************* Dynamic Card Display **********************************************


1. Create blade File 

@extends('layout.base')

<style>
    .bg-red {
        background-color: #f44336 !important;
        color: #fff
    }

    .bg-red .content .text,
    .bg-red .content .number {
        color: #fff !important
    }

    .bg-pink {
        background-color: #e91e63 !important;
        color: #fff
    }

    .bg-pink .content .text,
    .bg-pink .content .number {
        color: #fff !important
    }

    .bg-purple {
        background-color: #9c27b0 !important;
        color: #fff
    }

    .bg-purple .content .text,
    .bg-purple .content .number {
        color: #fff !important
    }

    .bg-deep-purple {
        background-color: #673ab7 !important;
        color: #fff
    }

    .bg-deep-purple .content .text,
    .bg-deep-purple .content .number {
        color: #fff !important
    }

    .bg-indigo {
        background-color: #6777ef !important;
        color: #fff
    }

    .bg-indigo .content .text,
    .bg-indigo .content .number {
        color: #fff !important
    }

    .bg-blue {
        background-color: #2196f3 !important;
        color: #fff
    }

    .bg-blue .content .text,
    .bg-blue .content .number {
        color: #fff !important
    }

    .bg-light-blue {
        background-color: #03a9f4 !important;
        color: #fff
    }

    .bg-light-blue .content .text,
    .bg-light-blue .content .number {
        color: #fff !important
    }

    .bg-cyan {
        background-color: #29c0b1 !important;
        color: #fff
    }

    .bg-cyan .content .text,
    .bg-cyan .content .number {
        color: #fff !important
    }

    .bg-teal {
        background-color: #009688 !important;
        color: #fff
    }

    .bg-teal .content .text,
    .bg-teal .content .number {
        color: #fff !important
    }

    .bg-green {
        background-color: #4caf50 !important;
        color: #fff
    }

    .bg-green .content .text,
    .bg-green .content .number {
        color: #fff !important
    }

    .bg-light-green {
        background-color: #8bc34a !important;
        color: #fff
    }

    .bg-light-green .content .text,
    .bg-light-green .content .number {
        color: #fff !important
    }

    .bg-lime {
        background-color: #cddc39 !important;
        color: #fff
    }

    .bg-lime .content .text,
    .bg-lime .content .number {
        color: #fff !important
    }

    .bg-yellow {
        background-color: #ffe821 !important;
        color: #fff
    }

    .bg-yellow .content .text,
    .bg-yellow .content .number {
        color: #fff !important
    }

    .bg-amber {
        background-color: #ffc107 !important;
        color: #fff
    }

    .bg-amber .content .text,
    .bg-amber .content .number {
        color: #fff !important
    }

    .bg-orange {
        background-color: #ff9800 !important;
        color: #fff
    }

    .bg-orange .content .text,
    .bg-orange .content .number {
        color: #fff !important
    }

    .bg-deep-orange {
        background-color: #ff5722 !important;
        color: #fff
    }

    .bg-deep-orange .content .text,
    .bg-deep-orange .content .number {
        color: #fff !important
    }

    .bg-brown {
        background-color: #795548 !important;
        color: #fff
    }

    .bg-brown .content .text,
    .bg-brown .content .number {
        color: #fff !important
    }

    .bg-grey {
        background-color: #9e9e9e !important;
        color: #fff
    }

    .bg-grey .content .text,
    .bg-grey .content .number {
        color: #fff !important
    }

    .bg-blue-grey {
        background-color: #607d8b !important;
        color: #fff
    }

    .bg-blue-grey .content .text,
    .bg-blue-grey .content .number {
        color: #fff !important
    }

    .bg-black {
        background-color: #000 !important;
        color: #fff
    }

    .bg-black .content .text,
    .bg-black .content .number {
        color: #fff !important
    }

    .bg-white {
        background-color: #fff !important;
        color: #fff
    }

    .bg-white .content .text,
    .bg-white .content .number {
        color: #fff !important
    }

    .bg-dark-gray {
        background-color: #888 !important;
        color: #fff
    }

    .bg-dark-gray .content .text,
    .bg-dark-gray .content .number {
        color: #fff !important
    }

    .l-bg-green {
        background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
        color: #fff
    }

    .l-bg-green .content .text,
    .l-bg-green .content .number {
        color: #fff !important
    }

    .l-bg-green-dark {
        background: linear-gradient(135deg, #23bdb8 0, #65a986 100%) !important;
        color: #fff
    }

    .l-bg-green-dark .content .text,
    .l-bg-green-dark .content .number {
        color: #fff !important
    }

    .l-bg-orange {
        background: linear-gradient(135deg, #f48665 0%, #fda23f 100%) !important;
        color: #fff
    }

    .l-bg-orange .content .text,
    .l-bg-orange .content .number {
        color: #fff !important
    }

    .l-bg-orange-dark {
        background: linear-gradient(135deg, #f48665 0, #d68e41 100%) !important;
        color: #fff
    }

    .l-bg-orange-dark .content .text,
    .l-bg-orange-dark .content .number {
        color: #fff !important
    }

    .l-bg-cyan {
        background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
        color: #fff
    }

    .l-bg-cyan .content .text,
    .l-bg-cyan .content .number {
        color: #fff !important
    }

    .l-bg-cyan-dark {
        background: linear-gradient(135deg, #289cf5, #4f8bb7) !important;
        color: #fff
    }

    .l-bg-cyan-dark .content .text,
    .l-bg-cyan-dark .content .number {
        color: #fff !important
    }

    .l-bg-red {
        background: linear-gradient(to right, #a77ffc 0%, #ff6eac 100%) !important;
        color: #fff
    }

    .l-bg-red .content .text,
    .l-bg-red .content .number {
        color: #fff !important
    }

    .l-bg-purple {
        background: linear-gradient(135deg, #9a56ff 0%, #e36cd9 100%) !important;
        color: #fff
    }

    .l-bg-purple .content .text,
    .l-bg-purple .content .number {
        color: #fff !important
    }

    .l-bg-purple-dark {
        background: linear-gradient(135deg, #8e4cf1 0, #c554bc 100%) !important;
        color: #fff
    }

    .l-bg-purple-dark .content .text,
    .l-bg-purple-dark .content .number {
        color: #fff !important
    }

    .l-bg-yellow {
        background: linear-gradient(to right, #f6e384, #ffd500) !important;
        color: #fff
    }

    .l-bg-yellow .content .text,
    .l-bg-yellow .content .number {
        color: #fff !important
    }

    .col-red {
        color: #f44336 !important
    }

    .col-pink {
        color: #e91e63 !important
    }

    .col-purple {
        color: #9c27b0 !important
    }

    .col-deep-purple {
        color: #673ab7 !important
    }

    .col-indigo {
        color: #6777ef !important
    }

    .col-blue {
        color: #2196f3 !important
    }

    .col-light-blue {
        color: #03a9f4 !important
    }

    .col-cyan {
        color: #29c0b1 !important
    }

    .col-teal {
        color: #009688 !important
    }

    .col-green {
        color: #4caf50 !important
    }

    .col-light-green {
        color: #8bc34a !important
    }

    .col-lime {
        color: #cddc39 !important
    }

    .col-yellow {
        color: #ffe821 !important
    }

    .col-amber {
        color: #ffc107 !important
    }

    .col-orange {
        color: #ff9800 !important
    }

    .col-deep-orange {
        color: #ff5722 !important
    }

    .col-brown {
        color: #795548 !important
    }

    .col-grey {
        color: #9e9e9e !important
    }

    .col-blue-grey {
        color: #607d8b !important
    }

    .col-black {
        color: #000 !important
    }

    .col-white {
        color: #fff !important
    }

    .col-dark-gray {
        color: #888 !important
    }

    .btn:focus,
    .btn:active,
    .btn:active:focus,
    .custom-select:focus,
    .form-control:focus {
        box-shadow: none !important;
        outline: none
    }

    a {
        color: #6777ef;
        font-weight: 500;
        transition: all .5s;
        text-decoration: none
    }

    a:not(.btn-social-icon):not(.btn-social):not(.page-link) .ion,
    a:not(.btn-social-icon):not(.btn-social):not(.page-link) .fas,
    a:not(.btn-social-icon):not(.btn-social):not(.page-link) .far,
    a:not(.btn-social-icon):not(.btn-social):not(.page-link) .fal,
    a:not(.btn-social-icon):not(.btn-social):not(.page-link) .fab {
        margin-left: 4px
    }

    .bg-primary {
        background-color: #6777ef !important
    }

    .bg-secondary {
        background-color: #cdd3d8 !important
    }

    .bg-success {
        background-color: #54ca68 !important
    }

    .bg-info {
        background-color: #3abaf4 !important
    }

    .bg-warning {
        background-color: #ffa426 !important
    }

    .bg-danger {
        background-color: #fc544b !important
    }

    .bg-light {
        background-color: #e3eaef !important
    }

    .bg-dark {
        background-color: #191d21 !important
    }

    .text-primary,
    .text-primary-all *,
    .text-primary-all *:before,
    .text-primary-all *:after {
        color: #6777ef !important
    }

    .text-secondary,
    .text-secondary-all *,
    .text-secondary-all *:before,
    .text-secondary-all *:after {
        color: #cdd3d8 !important
    }

    .text-success,
    .text-success-all *,
    .text-success-all *:before,
    .text-success-all *:after {
        color: #54ca68 !important
    }

    .text-info,
    .text-info-all *,
    .text-info-all *:before,
    .text-info-all *:after {
        color: #3abaf4 !important
    }

    .text-warning,
    .text-warning-all *,
    .text-warning-all *:before,
    .text-warning-all *:after {
        color: #ffa426 !important
    }

    .text-danger,
    .text-danger-all *,
    .text-danger-all *:before,
    .text-danger-all *:after {
        color: #fc544b !important
    }

    .text-light,
    .text-light-all *,
    .text-light-all *:before,
    .text-light-all *:after {
        color: #e3eaef !important
    }

    .text-white,
    .text-white-all *,
    .text-white-all *:before,
    .text-white-all *:after {
        color: #fff !important
    }

    .text-dark,
    .text-dark-all *,
    .text-dark-all *:before,
    .text-dark-all *:after {
        color: #191d21 !important
    }

    .font-weight-normal {
        font-weight: 500 !important
    }

    .lead {
        line-height: 34px
    }

    @media(max-width: 575.98px) {
        .lead {
            font-size: 17px;
            line-height: 30px
        }
    }


    p,
    ul:not(.list-unstyled),
    ol {
        line-height: 28px
    }

    .shadow {
        box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .1)
    }

    .text-muted {
        color: #98a6ad !important
    }

    .flex-1 {
        flex: 1
    }





    .card {
        background-color: #fff;
        border-radius: 10px;
        border: none;
        position: relative;
        margin-bottom: 30px;
        box-shadow: 0 .46875rem 2.1875rem rgba(90, 97, 105, .1), 0 .9375rem 1.40625rem rgba(90, 97, 105, .1), 0 .25rem .53125rem rgba(90, 97, 105, .12), 0 .125rem .1875rem rgba(90, 97, 105, .1)
    }

    .card .card-header,
    .card .card-body,
    .card .card-footer {
        background-color: transparent;
        padding: 20px 25px
    }

    .card .navbar {
        position: static
    }

    .card .card-body {
        padding-top: 20px;
        padding-bottom: 20px
    }

    .card .card-body .section-title {
        margin: 30px 0 10px 0;
        font-size: 16px
    }

    .card .card-body .section-title:before {
        margin-top: 8px
    }

    .card .card-body .section-title+.section-lead {
        margin-top: -5px
    }

    .card .card-body p {
        font-weight: 500
    }

    .card .card-header {
        border-bottom-color: #f9f9f9;
        line-height: 30px;
        -ms-grid-row-align: center;
        align-self: center;
        width: 100%;
        padding: 10px 25px;
        display: flex;
        align-items: center
    }

    .card .card-header .btn {
        margin-top: 1px;
        padding: 2px 15px
    }

    .card .card-header .btn:not(.note-btn) {
        border-radius: 30px
    }

    .card .card-header .btn:hover {
        box-shadow: none
    }

    .card .card-header .form-control {
        height: 31px;
        font-size: 13px;
        border-radius: 30px
    }

    .card .card-header .form-control+.input-group-btn .btn {
        margin-top: -1px
    }

    .card .card-header h4 {
        font-size: 17px;
        line-height: 28px;
        padding-right: 10px;
        margin-bottom: 0;
        color: #212529
    }

    .card .card-header h4+.card-header-action,
    .card .card-header h4+.card-header-form {
        margin-left: auto
    }

    .card .card-header h4+.card-header-action .btn,
    .card .card-header h4+.card-header-form .btn {
        font-size: 12px;
        border-radius: 30px !important;
        padding-left: 13px !important;
        padding-right: 13px !important
    }

    .card .card-header h4+.card-header-action .btn.active,
    .card .card-header h4+.card-header-form .btn.active {
        box-shadow: 0 2px 6px #acb5f6;
        background-color: #6777ef;
        color: #fff
    }

    .card .card-header h4+.card-header-action .dropdown,
    .card .card-header h4+.card-header-form .dropdown {
        display: inline
    }

    .card .card-header h4+.card-header-action .btn-group .btn,
    .card .card-header h4+.card-header-form .btn-group .btn {
        border-radius: 0 !important
    }

    .card .card-header h4+.card-header-action .btn-group .btn:first-child,
    .card .card-header h4+.card-header-form .btn-group .btn:first-child {
        border-radius: 30px 0 0 30px !important
    }

    .card .card-header h4+.card-header-action .btn-group .btn:last-child,
    .card .card-header h4+.card-header-form .btn-group .btn:last-child {
        border-radius: 0 30px 30px 0 !important
    }

    .card .card-header h4+.card-header-action .input-group .form-control,
    .card .card-header h4+.card-header-form .input-group .form-control {
        border-radius: 30px 0 0 30px !important
    }

    .card .card-header h4+.card-header-action .input-group .form-control+.input-group-btn .btn,
    .card .card-header h4+.card-header-form .input-group .form-control+.input-group-btn .btn {
        border-radius: 0 30px 30px 0 !important
    }

    .card .card-header h4+.card-header-action .input-group .input-group-btn+.form-control,
    .card .card-header h4+.card-header-form .input-group .input-group-btn+.form-control {
        border-radius: 0 30px 30px 0 !important
    }

    .card .card-header h4+.card-header-action .input-group .input-group-btn .btn,
    .card .card-header h4+.card-header-form .input-group .input-group-btn .btn {
        margin-top: -1px;
        border-radius: 30px 0 0 30px !important
    }

    .card .card-footer {
        background-color: transparent;
        border: none
    }

    .card.card-mt {
        margin-top: 30px
    }

    .card.card-progress:after {
        content: " ";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, .5);
        z-index: 99;
        z-index: 99
    }

    .card.card-progress .card-progress-dismiss {
        position: absolute;
        top: 66%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        z-index: 999;
        color: #fff !important;
        padding: 5px 13px
    }

    .card.card-progress.remove-spinner .card-progress-dismiss {
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%)
    }

    .card.card-progress:not(.remove-spinner):after {
        background-image: url("../img/spinner.svg");
        background-size: 80px;
        background-repeat: no-repeat;
        background-position: center
    }

    .card.card-primary {
        border-top: 2px solid #6777ef
    }

    .card.card-secondary {
        border-top: 2px solid #34395e
    }

    .card.card-success {
        border-top: 2px solid #54ca68
    }

    .card.card-danger {
        border-top: 2px solid #fc544b
    }

    .card.card-warning {
        border-top: 2px solid #ffa426
    }

    .card.card-info {
        border-top: 2px solid #3abaf4
    }

    .card.card-dark {
        border-top: 2px solid #191d21
    }

    .card.card-hero .card-header {
        padding: 40px;
        background-image: linear-gradient(to bottom, #6777ef, #95a0f4);
        color: #fff;
        overflow: hidden;
        height: auto;
        min-height: auto;
        display: block
    }

    .card.card-hero .card-header h4 {
        font-size: 40px;
        line-height: 1
    }

    .card.card-hero .card-header .card-description {
        margin-top: 5px;
        font-size: 16px
    }

    .card.card-hero .card-header .card-icon {
        float: right;
        color: #8c98f3;
        margin: -60px
    }

    .card.card-hero .card-header .card-icon .ion,
    .card.card-hero .card-header .card-icon .fas,
    .card.card-hero .card-header .card-icon .far,
    .card.card-hero .card-header .card-icon .fab,
    .card.card-hero .card-header .card-icon .fal {
        font-size: 140px
    }

    .card.card-statistic-1 .card-header,
    .card.card-statistic-2 .card-header {
        border-color: transparent;
        padding-bottom: 0;
        height: auto;
        min-height: auto;
        display: block
    }

    .card.card-statistic-1 .card-icon {
        width: 30px;
        height: 30px;
        margin: 10px 0px 0px 20px;
        border-radius: 3px;
        line-height: 78px;
        text-align: center;
        float: left;
        font-size: 30px
    }

    .card.card-statistic-1 .card-header h4,
    .card.card-statistic-2 .card-header h4 {
        line-height: 1.2;
        color: #98a6ad
    }

    .card.card-statistic-1 .card-body,
    .card.card-statistic-2 .card-body {
        padding-top: 0
    }

    .card.card-statistic-1 .card-body,
    .card.card-statistic-2 .card-body {
        font-size: 26px;
        font-weight: 700;
        color: #34395e;
        padding-bottom: 0
    }

    .card.card-statistic-1,
    .card.card-statistic-2 {
        display: inline-block;
        width: 100%
    }

    .card.card-statistic-1 .card-icon,
    .card.card-statistic-2 .card-icon {
        width: 80px;
        height: 80px;
        margin: 10px;
        border-radius: 3px;
        line-height: 94px;
        text-align: center;
        float: left;
        border-radius: 50px;
        margin-right: 15px
    }

    .card.card-statistic-1 .card-icon .ion,
    .card.card-statistic-1 .card-icon .fas,
    .card.card-statistic-1 .card-icon .far,
    .card.card-statistic-1 .card-icon .fab,
    .card.card-statistic-1 .card-icon .fal,
    .card.card-statistic-2 .card-icon .ion,
    .card.card-statistic-2 .card-icon .fas,
    .card.card-statistic-2 .card-icon .far,
    .card.card-statistic-2 .card-icon .fab,
    .card.card-statistic-2 .card-icon .fal {
        font-size: 22px;
        color: #fff
    }

    .card.card-statistic-1 .card-icon {
        line-height: 90px
    }

    .card.card-statistic-2 .card-icon {
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 22px;
        margin: 25px;
        box-shadow: 5px 3px 10px 0 rgba(21, 15, 15, .3);
        border-radius: 10px;
        background: #6777ef
    }

    .card.card-statistic-1 .card-header,
    .card.card-statistic-2 .card-header {
        padding-bottom: 0;
        padding-top: 25px
    }

    .card.card-statistic-2 .card-body {
        padding-top: 20px
    }

    .card.card-statistic-2 .card-header+.card-body,
    .card.card-statistic-2 .card-body+.card-header {
        padding-top: 0
    }

    .card.card-statistic-1 .card-header h4,
    .card.card-statistic-2 .card-header h4 {
        font-weight: 600;
        font-size: 13px;
        letter-spacing: .5px
    }

    .card.card-statistic-1 .card-header h4 {
        margin-bottom: 0
    }

    .card.card-statistic-2 .card-header h4 {
        text-transform: none;
        margin-bottom: 0
    }

    .card.card-statistic-1 .card-body {
        font-size: 20px
    }

    .card.card-statistic-2 .card-chart {
        padding-top: 20px;
        margin-left: -9px;
        margin-right: -1px;
        margin-bottom: -15px
    }

    .card.card-statistic-2 .card-chart canvas {
        height: 90px !important
    }

    .card .card-stats {
        width: 100%;
        display: inline-block;
        margin-top: 2px;
        margin-bottom: -6px
    }

    .card .card-stats .card-stats-title {
        padding: 15px 25px;
        background-color: #fff;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .3px
    }

    .card .card-stats .card-stats-items {
        display: flex;
        height: 50px;
        align-items: center
    }

    .card .card-stats .card-stats-item {
        width: calc(100% / 3);
        text-align: center;
        padding: 5px 20px
    }

    .card .card-stats .card-stats-item .card-stats-item-label {
        font-size: 12px;
        letter-spacing: .5px;
        margin-top: 4px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap
    }

    .card .card-stats .card-stats-item .card-stats-item-count {
        line-height: 1;
        margin-bottom: 8px;
        font-size: 20px;
        font-weight: 700
    }

    .card.card-large-icons {
        display: flex;
        flex-direction: row
    }

    .card.card-large-icons .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 150px;
        border-radius: 3px 0 0 3px
    }

    .card.card-large-icons .card-icon .ion,
    .card.card-large-icons .card-icon .fas,
    .card.card-large-icons .card-icon .far,
    .card.card-large-icons .card-icon .fab,
    .card.card-large-icons .card-icon .fal {
        font-size: 60px
    }

    .card.card-large-icons .card-body {
        padding: 25px 30px
    }

    .card.card-large-icons .card-body h4 {
        font-size: 18px
    }

    .card.card-large-icons .card-body p {
        opacity: .6;
        font-weight: 500
    }

    .card.card-large-icons .card-body a.card-cta {
        text-decoration: none
    }

    .card.card-large-icons .card-body a.card-cta i {
        margin-left: 7px
    }

    .card.bg-primary,
    .card.bg-danger,
    .card.bg-success,
    .card.bg-info,
    .card.bg-dark,
    .card.bg-warning {
        color: #fff
    }

    .card.bg-primary .card-header,
    .card.bg-danger .card-header,
    .card.bg-success .card-header,
    .card.bg-info .card-header,
    .card.bg-dark .card-header,
    .card.bg-warning .card-header {
        color: #fff;
        opacity: .9
    }

    .card .card-type-3 .card-circle {
        display: inline-flex;
        text-align: center;
        border-radius: 50%;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        height: 45px;
        width: 45px;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, .14), 0 7px 10px -5px rgba(76, 175, 80, .4)
    }

    .card .card-type-3 .card-circle i {
        font-size: 15px
    }

    .card .card-statistic-3 {
        position: relative;
        color: #fff;
        padding: 15px;
        border-radius: 3px;
        overflow: hidden
    }

    .card .card-statistic-3 .card-icon-large {
        font-size: 110px;
        width: 110px;
        height: 50px;
        text-shadow: 3px 7px rgba(0, 0, 0, .3)
    }

    .card .card-statistic-3 .card-icon {
        text-align: center;
        line-height: 50px;
        margin-left: 15px;
        color: #000;
        position: absolute;
        right: -5px;
        top: 20px;
        opacity: .1
    }

    .card .card-statistic-3 .banner-img img {
        max-width: 100%
    }

    .card .card-statistic-4 {
        position: relative;
        color: #000;
        padding: 15px;
        border-radius: 3px;
        overflow: hidden
    }

    .card .card-statistic-4 .card-icon-large {
        font-size: 110px;
        width: 110px;
        height: 50px;
        text-shadow: 3px 7px rgba(0, 0, 0, .3)
    }

    .card .card-statistic-4 .card-icon {
        text-align: center;
        line-height: 50px;
        margin-left: 15px;
        color: #000;
        position: absolute;
        right: -5px;
        top: 20px;
        opacity: .1
    }

    .card .card-statistic-4 .banner-img img {
        max-width: 100%;
        float: right
    }

    @media(max-width: 575.98px) {
        .card.card-large-icons {
            display: inline-block
        }

        .card.card-large-icons .card-icon {
            width: 100%;
            height: 200px
        }

        .col-xs-6 {
            -ms-flex: 0 0 50%;
            -webkit-box-flex: 0;
            flex: 0 0 50%;
            max-width: 50%
        }
    }

    @media(max-width: 767.98px) {
        .card .card-header {
            height: auto;
            flex-wrap: wrap
        }

        .card .card-header h4+.card-header-action,
        .card .card-header h4+.card-header-form {
            flex-grow: 0;
            width: 100%;
            margin-top: 10px
        }
    }

    @media(min-width: 768px)and (max-width: 991.98px) {
        .card .card-stats .card-stats-items {
            height: 49px
        }

        .card .card-stats .card-stats-items .card-stats-item {
            padding: 5px 7px
        }

        .card .card-stats .card-stats-items .card-stats-item .card-stats-item-count {
            font-size: 16px
        }

        .card.card-sm-6 .card-chart canvas {
            height: 85px !important
        }

        .card.card-hero .card-header {
            padding: 25px
        }
    }







    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active {
        color: #fff;
        background-color: #5864bd;
        border-color: #5864bd
    }

    .theme-purple.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-purple.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #5864bd
    }

    .theme-purple .bg-primary {
        background-color: #5864bd !important
    }

    .theme-purple .text-primary {
        color: #5864bd !important
    }

    .theme-purple a {
        color: #5864bd
    }

    .theme-purple a:hover {
        color: #5864bd
    }

    .theme-purple .btn-primary {
        background-color: #5864bd;
        border-color: transparent !important;
        color: #fff
    }

    .theme-purple .btn-primary:focus {
        background-color: #5864bd !important
    }

    .theme-purple .btn-primary:focus:active {
        background-color: #5864bd !important
    }

    .theme-purple .btn-primary:active {
        background-color: #5864bd !important
    }

    .theme-purple .btn-primary:hover {
        background-color: #5864bd !important;
        color: #fff
    }

    .theme-purple .btn-primary.disabled {
        background-color: #5864bd;
        border-color: #5864bd
    }

    .theme-purple .btn-primary:disabled {
        background-color: #5864bd;
        border-color: #5864bd
    }

    .theme-purple .btn-outline-primary {
        color: #5864bd;
        background-color: transparent;
        background-image: none;
        border-color: #5864bd
    }

    .theme-purple .btn-outline-primary:hover {
        color: #fff;
        background-color: #5864bd;
        border-color: #5864bd
    }

    .theme-purple .btn-outline-primary.disabled {
        color: #5864bd;
        background-color: transparent
    }

    .theme-purple .btn-outline-primary:disabled {
        color: #5864bd;
        background-color: transparent
    }

    .theme-purple .btn-link {
        font-weight: 400;
        color: #5864bd;
        background-color: transparent
    }

    .theme-purple .btn-link:hover {
        color: #5864bd
    }

    .theme-purple .dropdown-item.active {
        color: #fff;
        background-color: #5864bd
    }

    .theme-purple .dropdown-item:active {
        color: #fff;
        background-color: #5864bd
    }

    .theme-purple .nav-pills .nav-link.active {
        color: #fff;
        background-color: #5864bd
    }

    .theme-purple .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #5864bd
    }

    .theme-purple .page-link {
        color: #5864bd;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-purple .page-link:focus {
        color: #5864bd
    }

    .theme-purple .page-link:hover {
        color: #5864bd;
        background-color: #eaeaea
    }

    .theme-purple .page-item .page-link {
        color: #5864bd
    }

    .theme-purple .page-item.active .page-link {
        color: #fff;
        background-color: #5864bd;
        border-color: #5864bd
    }

    .theme-purple .page-item.disabled .page-link {
        color: #5864bd
    }

    .theme-purple .progress-bar {
        color: #fff;
        background-color: #5864bd
    }

    .theme-purple .border-primary {
        border-color: #5864bd !important
    }

    .theme-purple .navbar {
        background-color: #5864bd
    }

    .theme-purple .navbar .nav-link .feather {
        color: #fff
    }

    .theme-purple .jqvmap-circle {
        background-color: #5864bd;
        border: 1px solid #000
    }

    .theme-purple .dropzone {
        border: 2px dashed #5864bd
    }

    .theme-purple .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #5864bd
    }

    .theme-purple .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #5864bd
    }

    .theme-purple .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #5864bd
    }

    .theme-purple .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #5864bd
    }

    .theme-purple .list-group-item.active {
        color: #fff;
        background-color: #5864bd;
        border-color: #5864bd
    }

    .theme-purple .navbar.active {
        background-color: #5864bd
    }

    .theme-purple .form-control:focus {
        border-color: #5864bd
    }

    .theme-purple .alert.alert-primary {
        background-color: #5864bd
    }

    .theme-purple .card.card-primary {
        border-top: 2px solid #5864bd
    }

    .theme-purple .fc button.fc-state-active {
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple .weather ul li {
        border: 2px solid #5864bd;
        color: #5864bd
    }

    .theme-purple .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple .nav-tabs .nav-item .nav-link {
        color: #5864bd
    }

    .theme-purple .swal-button.swal-button--confirm {
        background-color: #5864bd
    }

    .theme-purple .btn-group .btn.active {
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple .media .media-right {
        color: #5864bd
    }

    .theme-purple .selectric-items li.selected {
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple .selectric-items li.highlighted {
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple .accordion .accordion-header[aria-expanded=true] {
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple .bootstrap-tagsinput .tag {
        background-color: #5864bd
    }

    .theme-purple body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #5864bd
    }

    .theme-purple body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #5e6cdd;
        background-color: #5864bd;
        color: #fff
    }

    .theme-purple body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #5864bd
    }

    .theme-purple .activities .activity:before {
        background-color: #5864bd
    }

    .theme-purple .settingSidebar .settingPanelToggle {
        background: #5864bd
    }

    .theme-purple .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-purple .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #5864bd
    }

    .theme-purple .custom-switch-input:checked~.custom-switch-indicator {
        background: #5864bd
    }

    .theme-purple .selectgroup-input:focus+.selectgroup-button,
    .theme-purple .selectgroup-input:checked+.selectgroup-button {
        background-color: #5864bd
    }

    .theme-purple .selectgroup-input-radio:focus+.selectgroup-button,
    .theme-purple .selectgroup-input-radio:checked+.selectgroup-button {
        background-color: #5864bd
    }

    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #3dc9b3;
        border-color: #3dc9b3
    }

    .theme-cyan.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-cyan.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #3dc9b3
    }

    .theme-cyan .bg-primary {
        background-color: #3dc9b3 !important
    }

    .theme-cyan .text-primary {
        color: #3dc9b3 !important
    }

    .theme-cyan a {
        color: #3dc9b3
    }

    .theme-cyan a:hover {
        color: #4bded5
    }

    .theme-cyan .btn-primary {
        background-color: #3dc9b3;
        border-color: transparent !important;
        color: #fff
    }

    .theme-cyan .btn-primary:focus {
        background-color: #4bded5 !important
    }

    .theme-cyan .btn-primary:focus:active {
        background-color: #4bded5 !important
    }

    .theme-cyan .btn-primary:active {
        background-color: #4bded5 !important
    }

    .theme-cyan .btn-primary:hover {
        background-color: #4bded5 !important;
        color: #fff
    }

    .theme-cyan .btn-primary.disabled {
        background-color: #3dc9b3;
        border-color: #3dc9b3
    }

    .theme-cyan .btn-primary:disabled {
        background-color: #3dc9b3;
        border-color: #3dc9b3
    }

    .theme-cyan .btn-outline-primary {
        color: #3dc9b3;
        background-color: transparent;
        background-image: none;
        border-color: #3dc9b3
    }

    .theme-cyan .btn-outline-primary:hover {
        color: #fff;
        background-color: #3dc9b3;
        border-color: #3dc9b3
    }

    .theme-cyan .btn-outline-primary.disabled {
        color: #3dc9b3;
        background-color: transparent
    }

    .theme-cyan .btn-outline-primary:disabled {
        color: #3dc9b3;
        background-color: transparent
    }

    .theme-cyan .btn-link {
        font-weight: 400;
        color: #3dc9b3;
        background-color: transparent
    }

    .theme-cyan .btn-link:hover {
        color: #4bded5
    }

    .theme-cyan .dropdown-item.active {
        color: #fff;
        background-color: #3dc9b3
    }

    .theme-cyan .dropdown-item:active {
        color: #fff;
        background-color: #3dc9b3
    }

    .theme-cyan .nav-pills .nav-link.active {
        color: #fff;
        background-color: #3dc9b3
    }

    .theme-cyan .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #3dc9b3
    }

    .theme-cyan .page-link {
        color: #3dc9b3;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-cyan .page-link:focus {
        color: #4bded5
    }

    .theme-cyan .page-link:hover {
        color: #4bded5;
        background-color: #eaeaea
    }

    .theme-cyan .page-item .page-link {
        color: #3dc9b3
    }

    .theme-cyan .page-item.active .page-link {
        color: #fff;
        background-color: #3dc9b3;
        border-color: #3dc9b3
    }

    .theme-cyan .page-item.disabled .page-link {
        color: #3dc9b3
    }

    .theme-cyan .progress-bar {
        color: #fff;
        background-color: #3dc9b3
    }

    .theme-cyan .border-primary {
        border-color: #3dc9b3 !important
    }

    .theme-cyan .navbar {
        background-color: #3dc9b3
    }

    .theme-cyan .jqvmap-circle {
        background-color: #3dc9b3;
        border: 1px solid #000
    }

    .theme-cyan .dropzone {
        border: 2px dashed #3dc9b3
    }

    .theme-cyan .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #3dc9b3
    }

    .theme-cyan .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #3dc9b3
    }

    .theme-cyan .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #3dc9b3
    }

    .theme-cyan .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #3dc9b3
    }

    .theme-cyan .list-group-item.active {
        color: #fff;
        background-color: #3dc9b3;
        border-color: #3dc9b3
    }

    .theme-cyan .navbar.active {
        background-color: #3dc9b3
    }

    .theme-cyan .form-control:focus {
        border-color: #3dc9b3
    }

    .theme-cyan .alert.alert-primary {
        background-color: #3dc9b3
    }

    .theme-cyan .card.card-primary {
        border-top: 2px solid #3dc9b3
    }

    .theme-cyan .fc button.fc-state-active {
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan .weather ul li {
        border: 2px solid #3dc9b3;
        color: #3dc9b3
    }

    .theme-cyan .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan .nav-tabs .nav-item .nav-link {
        color: #3dc9b3
    }

    .theme-cyan .swal-button.swal-button--confirm {
        background-color: #3dc9b3
    }

    .theme-cyan .btn-group .btn.active {
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan .media .media-right {
        color: #3dc9b3
    }

    .theme-cyan .selectric-items li.selected {
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan .selectric-items li.highlighted {
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan .accordion .accordion-header[aria-expanded=true] {
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan .bootstrap-tagsinput .tag {
        background-color: #3dc9b3
    }

    .theme-cyan body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #3dc9b3
    }

    .theme-cyan body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #8ddcd7;
        background-color: #3dc9b3;
        color: #fff
    }

    .theme-cyan body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #3dc9b3
    }

    .theme-cyan .activities .activity:before {
        background-color: #3dc9b3
    }

    .theme-cyan .settingSidebar .settingPanelToggle {
        background: #3dc9b3
    }

    .theme-cyan .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-cyan .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #3dc9b3
    }

    .theme-cyan .custom-switch-input:checked~.custom-switch-indicator {
        background: #3dc9b3
    }

    .theme-cyan .selectgroup-input:focus+.selectgroup-button,
    .theme-cyan .selectgroup-input:checked+.selectgroup-button {
        background-color: #3dc9b3
    }

    .theme-cyan .selectgroup-input-radio:focus+.selectgroup-button,
    .theme-cyan .selectgroup-input-radio:checked+.selectgroup-button {
        background-color: #3dc9b3
    }

    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #28c76f;
        border-color: #28c76f
    }

    .theme-green.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-green.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #28c76f
    }

    .theme-green .bg-primary {
        background-color: #28c76f !important
    }

    .theme-green .text-primary {
        color: #28c76f !important
    }

    .theme-green a {
        color: #28c76f
    }

    .theme-green a:hover {
        color: #85d888
    }

    .theme-green .btn-primary {
        background-color: #28c76f;
        border-color: transparent !important;
        color: #fff
    }

    .theme-green .btn-primary:focus {
        background-color: #85d888 !important
    }

    .theme-green .btn-primary:focus:active {
        background-color: #85d888 !important
    }

    .theme-green .btn-primary:active {
        background-color: #85d888 !important
    }

    .theme-green .btn-primary:hover {
        background-color: #85d888 !important;
        color: #fff
    }

    .theme-green .btn-primary.disabled {
        background-color: #28c76f;
        border-color: #28c76f
    }

    .theme-green .btn-primary:disabled {
        background-color: #28c76f;
        border-color: #28c76f
    }

    .theme-green .btn-outline-primary {
        color: #28c76f;
        background-color: transparent;
        background-image: none;
        border-color: #28c76f
    }

    .theme-green .btn-outline-primary:hover {
        color: #fff;
        background-color: #28c76f;
        border-color: #28c76f
    }

    .theme-green .btn-outline-primary.disabled {
        color: #28c76f;
        background-color: transparent
    }

    .theme-green .btn-outline-primary:disabled {
        color: #28c76f;
        background-color: transparent
    }

    .theme-green .btn-link {
        font-weight: 400;
        color: #28c76f;
        background-color: transparent
    }

    .theme-green .btn-link:hover {
        color: #85d888
    }

    .theme-green .dropdown-item.active {
        color: #fff;
        background-color: #28c76f
    }

    .theme-green .dropdown-item:active {
        color: #fff;
        background-color: #28c76f
    }

    .theme-green .nav-pills .nav-link.active {
        color: #fff;
        background-color: #28c76f
    }

    .theme-green .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #28c76f
    }

    .theme-green .page-link {
        color: #28c76f;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-green .page-link:focus {
        color: #85d888
    }

    .theme-green .page-link:hover {
        color: #85d888;
        background-color: #eaeaea
    }

    .theme-green .page-item .page-link {
        color: #28c76f
    }

    .theme-green .page-item.active .page-link {
        color: #fff;
        background-color: #28c76f;
        border-color: #28c76f
    }

    .theme-green .page-item.disabled .page-link {
        color: #28c76f
    }

    .theme-green .progress-bar {
        color: #fff;
        background-color: #28c76f
    }

    .theme-green .border-primary {
        border-color: #28c76f !important
    }

    .theme-green .navbar {
        background-color: #28c76f
    }

    .theme-green .jqvmap-circle {
        background-color: #28c76f;
        border: 1px solid #000
    }

    .theme-green .dropzone {
        border: 2px dashed #28c76f
    }

    .theme-green .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #28c76f
    }

    .theme-green .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #28c76f
    }

    .theme-green .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #28c76f
    }

    .theme-green .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #28c76f
    }

    .theme-green .list-group-item.active {
        color: #fff;
        background-color: #28c76f;
        border-color: #28c76f
    }

    .theme-green .navbar.active {
        background-color: #28c76f
    }

    .theme-green .form-control:focus {
        border-color: #28c76f
    }

    .theme-green .alert.alert-primary {
        background-color: #28c76f
    }

    .theme-green .card.card-primary {
        border-top: 2px solid #28c76f
    }

    .theme-green .fc button.fc-state-active {
        background-color: #28c76f;
        color: #fff
    }

    .theme-green .weather ul li {
        border: 2px solid #28c76f;
        color: #28c76f
    }

    .theme-green .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #28c76f;
        color: #fff
    }

    .theme-green .nav-tabs .nav-item .nav-link {
        color: #28c76f
    }

    .theme-green .swal-button.swal-button--confirm {
        background-color: #28c76f
    }

    .theme-green .btn-group .btn.active {
        background-color: #28c76f;
        color: #fff
    }

    .theme-green .media .media-right {
        color: #28c76f
    }

    .theme-green .selectric-items li.selected {
        background-color: #28c76f;
        color: #fff
    }

    .theme-green .selectric-items li.highlighted {
        background-color: #28c76f;
        color: #fff
    }

    .theme-green .accordion .accordion-header[aria-expanded=true] {
        background-color: #28c76f;
        color: #fff
    }

    .theme-green .bootstrap-tagsinput .tag {
        background-color: #28c76f
    }

    .theme-green body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #28c76f
    }

    .theme-green body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #64c367;
        background-color: #28c76f;
        color: #fff
    }

    .theme-green body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #28c76f
    }

    .theme-green .activities .activity:before {
        background-color: #28c76f
    }

    .theme-green .settingSidebar .settingPanelToggle {
        background: #28c76f
    }

    .theme-green .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-green .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #28c76f
    }

    .theme-green .custom-switch-input:checked~.custom-switch-indicator {
        background: #28c76f
    }

    .theme-green .selectgroup-input:focus+.selectgroup-button,
    .theme-green .selectgroup-input:checked+.selectgroup-button {
        background-color: #28c76f
    }

    .theme-green .selectgroup-input-radio:focus+.selectgroup-button,
    .theme-green .selectgroup-input-radio:checked+.selectgroup-button {
        background-color: #28c76f
    }

    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #ea5455;
        border-color: #ea5455
    }

    .theme-red.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-red.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #ea5455
    }

    .theme-red .bg-primary {
        background-color: #ea5455 !important
    }

    .theme-red .text-primary {
        color: #ea5455 !important
    }

    .theme-red a {
        color: #ea5455
    }

    .theme-red a:hover {
        color: #d8595a
    }

    .theme-red .btn-primary {
        background-color: #ea5455;
        border-color: transparent !important;
        color: #fff
    }

    .theme-red .btn-primary:focus {
        background-color: #d8595a !important
    }

    .theme-red .btn-primary:focus:active {
        background-color: #d8595a !important
    }

    .theme-red .btn-primary:active {
        background-color: #d8595a !important
    }

    .theme-red .btn-primary:hover {
        background-color: #d8595a !important;
        color: #fff
    }

    .theme-red .btn-primary.disabled {
        background-color: #ea5455;
        border-color: #ea5455
    }

    .theme-red .btn-primary:disabled {
        background-color: #ea5455;
        border-color: #ea5455
    }

    .theme-red .btn-outline-primary {
        color: #ea5455;
        background-color: transparent;
        background-image: none;
        border-color: #ea5455
    }

    .theme-red .btn-outline-primary:hover {
        color: #fff;
        background-color: #ea5455;
        border-color: #ea5455
    }

    .theme-red .btn-outline-primary.disabled {
        color: #ea5455;
        background-color: transparent
    }

    .theme-red .btn-outline-primary:disabled {
        color: #ea5455;
        background-color: transparent
    }

    .theme-red .btn-link {
        font-weight: 400;
        color: #ea5455;
        background-color: transparent
    }

    .theme-red .btn-link:hover {
        color: #d8595a
    }

    .theme-red .dropdown-item.active {
        color: #fff;
        background-color: #ea5455
    }

    .theme-red .dropdown-item:active {
        color: #fff;
        background-color: #ea5455
    }

    .theme-red .nav-pills .nav-link.active {
        color: #fff;
        background-color: #ea5455
    }

    .theme-red .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #ea5455
    }

    .theme-red .page-link {
        color: #ea5455;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-red .page-link:focus {
        color: #d8595a
    }

    .theme-red .page-link:hover {
        color: #d8595a;
        background-color: #eaeaea
    }

    .theme-red .page-item .page-link {
        color: #ea5455
    }

    .theme-red .page-item.active .page-link {
        color: #fff;
        background-color: #ea5455;
        border-color: #ea5455
    }

    .theme-red .page-item.disabled .page-link {
        color: #ea5455
    }

    .theme-red .progress-bar {
        color: #fff;
        background-color: #ea5455
    }

    .theme-red .border-primary {
        border-color: #ea5455 !important
    }

    .theme-red .navbar {
        background-color: #ea5455
    }

    .theme-red .jqvmap-circle {
        background-color: #ea5455;
        border: 1px solid #000
    }

    .theme-red .dropzone {
        border: 2px dashed #ea5455
    }

    .theme-red .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #ea5455
    }

    .theme-red .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #ea5455
    }

    .theme-red .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #ea5455
    }

    .theme-red .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #ea5455
    }

    .theme-red .list-group-item.active {
        color: #fff;
        background-color: #ea5455;
        border-color: #ea5455
    }

    .theme-red .navbar.active {
        background-color: #ea5455
    }

    .theme-red .form-control:focus {
        border-color: #ea5455
    }

    .theme-red .alert.alert-primary {
        background-color: #ea5455
    }

    .theme-red .card.card-primary {
        border-top: 2px solid #ea5455
    }

    .theme-red .fc button.fc-state-active {
        background-color: #ea5455;
        color: #fff
    }

    .theme-red .weather ul li {
        border: 2px solid #ea5455;
        color: #ea5455
    }

    .theme-red .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #ea5455;
        color: #fff
    }

    .theme-red .nav-tabs .nav-item .nav-link {
        color: #ea5455
    }

    .theme-red .swal-button.swal-button--confirm {
        background-color: #ea5455
    }

    .theme-red .btn-group .btn.active {
        background-color: #ea5455;
        color: #fff
    }

    .theme-red .media .media-right {
        color: #ea5455
    }

    .theme-red .selectric-items li.selected {
        background-color: #ea5455;
        color: #fff
    }

    .theme-red .selectric-items li.highlighted {
        background-color: #ea5455;
        color: #fff
    }

    .theme-red .accordion .accordion-header[aria-expanded=true] {
        background-color: #ea5455;
        color: #fff
    }

    .theme-red .bootstrap-tagsinput .tag {
        background-color: #ea5455
    }

    .theme-red body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #ea5455
    }

    .theme-red body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #ef6d6e;
        background-color: #ea5455;
        color: #fff
    }

    .theme-red body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #ea5455
    }

    .theme-red .activities .activity:before {
        background-color: #ea5455
    }

    .theme-red .settingSidebar .settingPanelToggle {
        background: #ea5455
    }

    .theme-red .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-red .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #ea5455
    }

    .theme-red .custom-switch-input:checked~.custom-switch-indicator {
        background: #ea5455
    }

    .theme-red .selectgroup-input:focus+.selectgroup-button,
    .theme-red .selectgroup-input:checked+.selectgroup-button {
        background-color: #ea5455
    }

    .theme-red .selectgroup-input-radio:focus+.selectgroup-button,
    .theme-red .selectgroup-input-radio:checked+.selectgroup-button {
        background-color: #ea5455
    }

    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #ffa117;
        border-color: #ffa117
    }

    .theme-orange.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-orange.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #ffa117
    }

    .theme-orange .bg-primary {
        background-color: #ffa117 !important
    }

    .theme-orange .text-primary {
        color: #ffa117 !important
    }

    .theme-orange a {
        color: #ffa117
    }

    .theme-orange a:hover {
        color: #efb45f
    }

    .theme-orange .btn-primary {
        background-color: #ffa117;
        border-color: transparent !important;
        color: #fff
    }

    .theme-orange .btn-primary:focus {
        background-color: #efb45f !important
    }

    .theme-orange .btn-primary:focus:active {
        background-color: #efb45f !important
    }

    .theme-orange .btn-primary:active {
        background-color: #efb45f !important
    }

    .theme-orange .btn-primary:hover {
        background-color: #efb45f !important;
        color: #fff
    }

    .theme-orange .btn-primary.disabled {
        background-color: #ffa117;
        border-color: #ffa117
    }

    .theme-orange .btn-primary:disabled {
        background-color: #ffa117;
        border-color: #ffa117
    }

    .theme-orange .btn-outline-primary {
        color: #ffa117;
        background-color: transparent;
        background-image: none;
        border-color: #ffa117
    }

    .theme-orange .btn-outline-primary:hover {
        color: #fff;
        background-color: #ffa117;
        border-color: #ffa117
    }

    .theme-orange .btn-outline-primary.disabled {
        color: #ffa117;
        background-color: transparent
    }

    .theme-orange .btn-outline-primary:disabled {
        color: #ffa117;
        background-color: transparent
    }

    .theme-orange .btn-link {
        font-weight: 400;
        color: #ffa117;
        background-color: transparent
    }

    .theme-orange .btn-link:hover {
        color: #efb45f
    }

    .theme-orange .dropdown-item.active {
        color: #fff;
        background-color: #ffa117
    }

    .theme-orange .dropdown-item:active {
        color: #fff;
        background-color: #ffa117
    }

    .theme-orange .nav-pills .nav-link.active {
        color: #fff;
        background-color: #ffa117
    }

    .theme-orange .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #ffa117
    }

    .theme-orange .page-link {
        color: #ffa117;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-orange .page-link:focus {
        color: #efb45f
    }

    .theme-orange .page-link:hover {
        color: #efb45f;
        background-color: #eaeaea
    }

    .theme-orange .page-item .page-link {
        color: #ffa117
    }

    .theme-orange .page-item.active .page-link {
        color: #fff;
        background-color: #ffa117;
        border-color: #ffa117
    }

    .theme-orange .page-item.disabled .page-link {
        color: #ffa117
    }

    .theme-orange .progress-bar {
        color: #fff;
        background-color: #ffa117
    }

    .theme-orange .border-primary {
        border-color: #ffa117 !important
    }

    .theme-orange .navbar {
        background-color: #ffa117
    }

    .theme-orange .jqvmap-circle {
        background-color: #ffa117;
        border: 1px solid #000
    }

    .theme-orange .dropzone {
        border: 2px dashed #ffa117
    }

    .theme-orange .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #ffa117
    }

    .theme-orange .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #ffa117
    }

    .theme-orange .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #ffa117
    }

    .theme-orange .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #ffa117
    }

    .theme-orange .list-group-item.active {
        color: #fff;
        background-color: #ffa117;
        border-color: #ffa117
    }

    .theme-orange .navbar.active {
        background-color: #ffa117
    }

    .theme-orange .form-control:focus {
        border-color: #ffa117
    }

    .theme-orange .alert.alert-primary {
        background-color: #ffa117
    }

    .theme-orange .card.card-primary {
        border-top: 2px solid #ffa117
    }

    .theme-orange .fc button.fc-state-active {
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange .weather ul li {
        border: 2px solid #ffa117;
        color: #ffa117
    }

    .theme-orange .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange .nav-tabs .nav-item .nav-link {
        color: #ffa117
    }

    .theme-orange .swal-button.swal-button--confirm {
        background-color: #ffa117
    }

    .theme-orange .btn-group .btn.active {
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange .media .media-right {
        color: #ffa117
    }

    .theme-orange .selectric-items li.selected {
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange .selectric-items li.highlighted {
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange .accordion .accordion-header[aria-expanded=true] {
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange .bootstrap-tagsinput .tag {
        background-color: #ffa117
    }

    .theme-orange body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #ffa117
    }

    .theme-orange body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #f1a535;
        background-color: #ffa117;
        color: #fff
    }

    .theme-orange body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #ffa117
    }

    .theme-orange .activities .activity:before {
        background-color: #ffa117
    }

    .theme-orange .settingSidebar .settingPanelToggle {
        background: #ffa117
    }

    .theme-orange .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-orange .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #ffa117
    }

    .theme-orange .custom-switch-input:checked~.custom-switch-indicator {
        background: #ffa117
    }

    .theme-orange .selectgroup-input:focus+.selectgroup-button,
    .theme-orange .selectgroup-input:checked+.selectgroup-button {
        background-color: #ffa117
    }

    .theme-orange .selectgroup-input-radio:focus+.selectgroup-button,
    .theme-orange .selectgroup-input-radio:checked+.selectgroup-button {
        background-color: #ffa117
    }

    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle {
        color: #000;
        background-color: #6777ef;
        border-color: #6777ef
    }

    .theme-white.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-white.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a:hover {
        color: #6777ef
    }

    .theme-white .bg-primary {
        background-color: #6777ef !important
    }

    .theme-white .text-primary {
        color: #fff !important
    }

    .theme-white a:hover {
        color: #6777ef
    }

    .theme-white .btn-primary {
        background-color: #6777ef;
        border-color: transparent !important;
        color: #fff
    }

    .theme-white .btn-primary:focus {
        background-color: #4f5ece !important
    }

    .theme-white .btn-primary:focus:active {
        background-color: #4f5ece !important
    }

    .theme-white .btn-primary:active {
        background-color: #4f5ece !important
    }

    .theme-white .btn-primary:hover {
        background-color: #4f5ece !important;
        color: #fff
    }

    .theme-white .btn-primary.disabled {
        background-color: #6777ef;
        border-color: #6777ef
    }

    .theme-white .btn-primary:disabled {
        background-color: #6777ef;
        border-color: #6777ef
    }

    .theme-white .btn-outline-primary {
        color: #6777ef;
        background-color: transparent;
        background-image: none;
        border-color: #6777ef
    }

    .theme-white .btn-outline-primary:focus {
        background-color: #4f5ece !important;
        color: #fff
    }

    .theme-white .btn-outline-primary:focus:active {
        background-color: #4f5ece !important;
        color: #fff
    }

    .theme-white .btn-outline-primary:hover {
        color: #fff;
        background-color: #6777ef;
        border-color: #6777ef
    }

    .theme-white .btn-outline-primary.disabled {
        color: #6777ef;
        background-color: transparent
    }

    .theme-white .btn-outline-primary:disabled {
        color: #6777ef;
        background-color: transparent
    }

    .theme-white .btn-link {
        font-weight: 400;
        color: #6777ef;
        background-color: transparent
    }

    .theme-white .btn-link:hover {
        color: #6777ef
    }

    .theme-white .dropdown-item.active {
        color: #fff;
        background-color: #e9e9e9
    }

    .theme-white .nav-pills .nav-link.active {
        color: #fff;
        background-color: #6777ef
    }

    .theme-white .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #6777ef
    }

    .theme-white .page-link {
        color: #6777ef;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-white .page-link:focus {
        color: #6777ef
    }

    .theme-white .page-link:hover {
        color: #6777ef;
        background-color: #eaeaea
    }

    .theme-white .page-item .page-link {
        color: #6777ef
    }

    .theme-white .page-item.active .page-link {
        color: #fff;
        background-color: #6777ef;
        border-color: #6777ef
    }

    .theme-white .page-item.disabled .page-link {
        color: #6777ef
    }

    .theme-white .progress-bar {
        color: #fff;
        background-color: #6777ef
    }

    .theme-white .border-primary {
        border-color: #fff !important
    }

    .theme-white .navbar {
        background-color: #fff;
        box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .1)
    }

    .theme-white .jqvmap-circle {
        background-color: #6777ef;
        border: 1px solid #000
    }

    .theme-white .dropzone {
        border: 2px dashed #6777ef
    }

    .theme-white .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #6777ef
    }

    .theme-white .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #6777ef
    }

    .theme-white .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #6777ef
    }

    .theme-white .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #6777ef
    }

    .theme-white .list-group-item.active {
        color: #fff;
        background-color: #6777ef;
        border-color: #6777ef
    }

    .theme-white .navbar.active {
        background-color: #6777ef
    }

    .theme-white .form-control:focus {
        border-color: #6777ef
    }

    .theme-white .alert.alert-primary {
        background-color: #6777ef
    }

    .theme-white .card.card-primary {
        border-top: 2px solid #6777ef
    }

    .theme-white .fc button.fc-state-active {
        background-color: #6777ef;
        color: #fff
    }

    .theme-white .weather ul li {
        border: 2px solid #6777ef;
        color: #6777ef
    }

    .theme-white .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #6777ef;
        color: #fff
    }

    .theme-white .nav-tabs .nav-item .nav-link {
        color: #6777ef
    }

    .theme-white .swal-button.swal-button--confirm {
        background-color: #6777ef
    }

    .theme-white .btn-group .btn.active {
        background-color: #6777ef;
        color: #fff
    }

    .theme-white .media .media-right {
        color: #6777ef
    }

    .theme-white .selectric-items li.selected {
        background-color: #6777ef;
        color: #fff
    }

    .theme-white .selectric-items li.highlighted {
        background-color: #6777ef;
        color: #fff
    }

    .theme-white .accordion .accordion-header[aria-expanded=true] {
        background-color: #6777ef;
        color: #fff
    }

    .theme-white .bootstrap-tagsinput .tag {
        background-color: #6777ef
    }

    .theme-white body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #6777ef
    }

    .theme-white body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #6777ef;
        background-color: #6777ef;
        color: #fff
    }

    .theme-white body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #6777ef
    }

    .theme-white .activities .activity:before {
        background-color: #6777ef
    }

    .theme-white .settingSidebar .settingPanelToggle {
        background: #6777ef
    }

    .theme-white .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-white .settingSidebar ul.choose-theme li.active div::after {
        color: #000
    }

    .theme-white .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #6777ef
    }

    .theme-white .navbar .nav-link .feather {
        color: #555556
    }

    .theme-white .navbar .form-inline .form-control {
        background-color: #e9ecef
    }

    .theme-white .navbar .form-inline .form-control:focus {
        border-color: transparent
    }

    .theme-white .navbar .form-inline .btn {
        background-color: #e9ecef
    }

    .theme-white .custom-switch-input:checked~.custom-switch-indicator {
        background: #6777ef
    }

    .theme-black .show>.btn-outline-primary.dropdown-toggle,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-black .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-purple .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-purple .show>.btn-outline-primary.dropdown-toggle,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-cyan .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-cyan .show>.btn-outline-primary.dropdown-toggle,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-green .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-green .show>.btn-outline-primary.dropdown-toggle,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-red .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-red .show>.btn-outline-primary.dropdown-toggle,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-orange .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-orange .show>.btn-outline-primary.dropdown-toggle,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled):active,
    .theme-white .btn-outline-primary:not([disabled]):not(.disabled).active,
    .theme-white .show>.btn-outline-primary.dropdown-toggle {
        color: #fff;
        background-color: #191919;
        border-color: #191919
    }

    .theme-black.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        background-color: rgba(0, 0, 0, .14)
    }

    .theme-black .bg-primary {
        background-color: #191919 !important
    }

    .theme-black .text-primary {
        color: #fff !important
    }

    .theme-black a {
        color: #96a2b4
    }

    .theme-black a:hover {
        color: #96a2b4;
        text-decoration: none
    }

    .theme-black .buttons a {
        color: #fff
    }

    .theme-black .btn-primary {
        background-color: #191919;
        border-color: transparent !important;
        color: #fff
    }

    .theme-black .btn-primary:focus {
        background-color: #191919 !important
    }

    .theme-black .btn-primary:focus:active {
        background-color: #191919 !important
    }

    .theme-black .btn-primary:active {
        background-color: #191919 !important
    }

    .theme-black .btn-primary:hover {
        background-color: #191919 !important;
        color: #fff
    }

    .theme-black .btn-primary.disabled {
        background-color: #191919;
        border-color: #191919
    }

    .theme-black .btn-primary:disabled {
        background-color: #191919;
        border-color: #191919
    }

    .theme-black .btn-outline-primary {
        color: #191919;
        background-color: transparent;
        background-image: none;
        border-color: #191919
    }

    .theme-black .btn-outline-primary:hover {
        color: #fff;
        background-color: #191919;
        border-color: #191919
    }

    .theme-black .btn-outline-primary.disabled {
        color: #191919;
        background-color: transparent
    }

    .theme-black .btn-outline-primary:disabled {
        color: #191919;
        background-color: transparent
    }

    .theme-black .btn-link {
        font-weight: 400;
        color: #191919;
        background-color: transparent
    }

    .theme-black .btn-link:hover {
        color: #191919
    }

    .theme-black .dropdown-item.active {
        color: #fff;
        background-color: #191919
    }

    .theme-black .dropdown-item:active {
        color: #fff;
        background-color: #191919
    }

    .theme-black .nav-pills .nav-link.active {
        color: #fff;
        background-color: #191919
    }

    .theme-black .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #191919
    }

    .theme-black .page-link {
        color: #191919;
        background-color: #fff;
        border: 1px solid #ededed
    }

    .theme-black .page-link:focus {
        color: #191919
    }

    .theme-black .page-link:hover {
        color: #191919;
        background-color: #eaeaea
    }

    .theme-black .page-item .page-link {
        color: #191919
    }

    .theme-black .page-item.active .page-link {
        color: #fff;
        background-color: #191919;
        border-color: #191919
    }

    .theme-black .page-item.disabled .page-link {
        color: #191919
    }

    .theme-black .progress-bar {
        color: #fff;
        background-color: #191919
    }

    .theme-black .border-primary {
        border-color: #191919 !important
    }

    .theme-black .navbar {
        background-color: #353c48
    }

    .theme-black .navbar .form-inline .form-control {
        background-color: #212429 !important;
        border-color: #212429
    }

    .theme-black .navbar .form-inline .btn {
        background-color: #212429 !important
    }

    .theme-black .navbar .form-inline .btn i {
        color: #96a2b4
    }

    .theme-black .jqvmap-circle {
        background-color: #191919;
        border: 1px solid #000
    }

    .theme-black .dropzone {
        border: 2px dashed #191919
    }

    .theme-black .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #191919
    }

    .theme-black .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #191919
    }

    .theme-black .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #191919
    }

    .theme-black .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #191919
    }

    .theme-black .list-group-item.active {
        color: #fff;
        background-color: #191919;
        border-color: #191919
    }

    .theme-black .navbar.active {
        background-color: #191919
    }

    .theme-black .form-control:focus {
        border-color: #191919
    }

    .theme-black .alert.alert-primary {
        background-color: #191919
    }

    .theme-black .card.card-primary {
        border-top: 2px solid #191919
    }

    .theme-black .fc button.fc-state-active {
        background-color: #191919;
        color: #fff
    }

    .theme-black .weather ul li {
        border: 2px solid #191919;
        color: #191919
    }

    .theme-black .card-chat .chat-content .chat-item.chat-right .chat-details .chat-text {
        background-color: #191919;
        color: #fff
    }

    .theme-black .nav-tabs .nav-item .nav-link {
        color: #191919
    }

    .theme-black .swal-button.swal-button--confirm {
        background-color: #191919
    }

    .theme-black .btn-group .btn.active {
        background-color: #191919;
        color: #fff
    }

    .theme-black .media .media-right {
        color: #191919
    }

    .theme-black .selectric-items li.selected {
        background-color: #191919;
        color: #fff
    }

    .theme-black .selectric-items li.highlighted {
        background-color: #191919;
        color: #fff
    }

    .theme-black .accordion .accordion-header[aria-expanded=true] {
        background-color: #191919;
        color: #fff
    }

    .theme-black .bootstrap-tagsinput .tag {
        background-color: #191919
    }

    .theme-black body:not(.sidebar-mini) .sidebar-style-2 .sidebar-menu>li.active>a:before {
        background-color: #191919
    }

    .theme-black body.sidebar-mini .main-sidebar .sidebar-menu>li.active>a {
        box-shadow: 0 4px 8px #191919;
        background-color: #191919;
        color: #fff
    }

    .theme-black body.sidebar-mini .main-sidebar .sidebar-menu>li ul.dropdown-menu li.active>a {
        color: #191919
    }

    .theme-black .activities .activity:before {
        background-color: #191919
    }

    .theme-black .settingSidebar .settingPanelToggle {
        background: #191919
    }

    .theme-black .settingSidebar .settingPanelToggle i {
        color: #fff
    }

    .theme-black .sidebar-color .selectgroup-input:checked+.selectgroup-button {
        background-color: #191919
    }

    .theme-black .custom-switch-input:checked~.custom-switch-indicator {
        background: #191919
    }

    .theme-black .selectgroup-input:focus+.selectgroup-button,
    .theme-black .selectgroup-input:checked+.selectgroup-button {
        background-color: #191919
    }

    .theme-black .selectgroup-input-radio:focus+.selectgroup-button,
    .theme-black .selectgroup-input-radio:checked+.selectgroup-button {
        background-color: #191919
    }

    .dark .select2-container .select2-selection--single,
    .dark .select2-container .select2-selection--multiple,
    .dark .custom-file-label,
    .dark .custom-select {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark {
        background-color: #3b4452
    }

    .dark .card {
        background-color: #353c48;
        color: #96a2b4
    }

    .dark .card .card-header {
        border-bottom-color: #353c48
    }

    .dark .card .card-header h4+.card-header-action .btn {
        color: #fff;
        box-shadow: none
    }

    .dark .card .card-header h4+.card-header-action .btn.active {
        box-shadow: none;
        color: #fff
    }

    .dark .card .card-header h4 {
        color: #96a2b4
    }

    .dark .card .card-body p {
        color: #96a2b4
    }

    .dark .card.card-statistic-1 .card-body {
        color: #96a2b4
    }

    .dark .card.card-statistic-2 .card-body {
        color: #96a2b4
    }

    .dark .card .card-statistic-4 .card-content {
        color: #96a2b4
    }

    .dark .section .section-header h1 {
        color: #96a2b4
    }

    .dark .section .section-header .section-header-breadcrumb {
        background: #353c48
    }

    .dark .section .section-title {
        color: #96a2b4
    }

    .dark .navbar.active {
        background-color: #fff
    }

    .dark .navbar .form-inline .form-control {
        background-color: #f2f2f2
    }

    .dark .navbar .form-inline .btn {
        background-color: #f2f2f2
    }

    .dark .navbar .form-inline .search-element .form-control:focus {
        border-color: #30353d
    }

    .dark .navbar .form-inline .search-element .btn i {
        color: #96a2b4
    }

    .dark .table {
        color: #96a2b4 !important
    }

    .dark .table th {
        color: #96a2b4 !important;
        border: 1px solid #212429
    }

    .dark .table td {
        color: #96a2b4 !important;
        border: 1px solid #212429
    }

    .dark .table.table-bordered td {
        border-color: #666869
    }

    .dark .table.table-bordered th {
        border-color: #666869
    }

    .dark .table:not(.table-sm) thead th {
        color: #96a2b4;
        background-color: rgba(0, 0, 0, .2)
    }

    .dark .btn-primary {
        box-shadow: none
    }

    .dark .btn-secondary {
        box-shadow: none
    }

    .dark .btn-info {
        box-shadow: none
    }

    .dark .btn-warning {
        box-shadow: none
    }

    .dark .btn-danger {
        box-shadow: none
    }

    .dark .btn-success {
        box-shadow: none
    }

    .dark .btn-light {
        box-shadow: none
    }

    .dark .btn-dark {
        box-shadow: none
    }

    .dark .text-title {
        color: #96a2b4
    }

    .dark .text-muted {
        color: #64789a !important
    }

    .dark .main-footer {
        border-top: 1px solid #353c48;
        background: #353c48
    }

    .dark .btn-outline-primary {
        color: #96a2b4;
        border-color: #96a2b4
    }

    .dark .form-control {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark .select2-container.select2-container--focus .select2-selection--multiple {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark .select2-container.select2-container--open .select2-selection--single {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark .selectric {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark .selectric .label {
        color: #96a2b4
    }

    .dark .selectric:hover {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #32363c
    }

    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #32363c
    }

    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #96a2b4
    }

    .dark .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #353c48;
        color: #96a2b4
    }

    .dark .select2-container--default .select2-search--inline .select2-search__field {
        color: #96a2b4
    }

    .dark .select2-dropdown {
        background-color: #353c48;
        color: #96a2b4
    }

    .dark .bootstrap-tagsinput {
        background-color: #353c48;
        border-color: #979da6;
        color: #96a2b4
    }

    .dark .selectgroup-button {
        background-color: #353c48
    }

    .dark .custom-switch-indicator {
        background: #585b5f
    }

    .dark .selectric-items {
        background-color: #353c48;
        box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .3);
        color: #96a2b4
    }

    .dark .selectric-items li {
        color: #96a2b4
    }

    .dark .selectric-items li.selected {
        background-color: #33333a
    }

    .dark .selectric-items li.highlighted {
        background-color: #33333a
    }

    .dark .selectric-items li:hover {
        background-color: #37373e
    }

    .dark .custom-switch-description {
        color: #96a2b4
    }

    .dark .input-group-text {
        background-color: #32363c;
        color: #96a2b4
    }

    .dark .custom-file-label::after {
        background-color: #32363c;
        color: #96a2b4
    }

    .dark .jumbotron {
        background-color: #32363c
    }

    .dark .article .article-details {
        background-color: #353c48
    }

    .dark .article .article-details p {
        color: #96a2b4
    }

    .dark .article.article-style-b .article-details p {
        color: #96a2b4
    }

    .dark .article.article-style-c .article-details p {
        color: #96a2b4
    }

    .dark .article.article-style-c .article-details .article-category {
        color: #96a2b4
    }

    .dark .article.article-style-c .article-details .article-category a {
        color: #96a2b4
    }

    .dark .text-job {
        color: #96a2b4
    }

    .dark #mail-nav li a {
        color: #96a2b4
    }

    .dark #mail-nav #mail-folders>li a:hover {
        background-color: #313131
    }

    .dark #mail-nav #mail-labels li a:hover {
        background-color: #313131
    }

    .dark #mail-nav #online-offline li a:hover {
        background-color: #313131
    }

    .dark .breadcrumb {
        background-color: #353c48
    }

    .dark .dropdown-menu {
        background-color: #353c48;
        box-shadow: 0 4px 25px 0 rgba(0, 0, 0, .3)
    }

    .dark .dropdown-menu a:hover {
        color: #fff;
        background-color: #32363c
    }

    .dark .dropdown-menu .dropdown-title {
        color: #fff !important
    }

    .dark .dropdown-item {
        color: #96a2b4;
        background-color: #353c48
    }

    .dark .dropdown-divider {
        border-top-color: #96a2b4
    }

    .dark .dropdown-list .dropdown-item {
        border-bottom: 1px solid #96a2b4
    }

    .dark .dropdown-list .dropdown-item .dropdown-item-desc {
        color: #96a2b4
    }

    .dark .dropdown-list .dropdown-item .dropdown-item-desc b {
        color: #fff
    }

    .dark .dropdown-list .dropdown-item.dropdown-item-unread {
        background-color: #32363c
    }

    .dark .dropdown-list .dropdown-list-content:not(.is-end):after {
        background-image: none
    }

    .dark .dropdown-list .dropdown-list-message .dropdown-item .dropdown-item-desc .message-user {
        color: #96a2b4
    }

    .dark .dropdown-list .dropdown-list-message .dropdown-item .dropdown-item-desc .messege-text {
        color: #96a2b4
    }

    .dark .list-group-item {
        background-color: #353c48;
        border: 1px solid rgba(234, 227, 227, .2);
        color: #96a2b4
    }

    .dark .list-group-item.disabled {
        background-color: #343a40
    }

    .dark .list-group-item-action {
        color: #96a2b4
    }

    .dark .dropzone {
        border: 2px dashed #96a2b4;
        background: #353c48
    }

    .dark .dropzone .dz-message {
        color: #96a2b4
    }

    .dark .pricing {
        background: #353c48
    }

    .dark .pricing .pricing-cta a {
        background-color: #32363c
    }

    .dark .settingSidebar .settingSidebar-body {
        background: #353c48;
        color: #96a2b4
    }

    .dark .settingSidebar .settingSidebar-body .border-bottom {
        border-bottom: 1px solid #191919 !important
    }

    .dark .settingSidebar .setting-panel-header {
        background-color: #32363c;
        color: #96a2b4;
        border: 1px solid #32363c
    }

    .dark .image-preview {
        background-color: #353c48
    }

    .dark .invoice {
        background-color: #353c48
    }

    .dark .invoice .invoice-detail-item .invoice-detail-value {
        color: #fff
    }

    .dark .main-wrapper-1 .section .section-header {
        border-top: 1px solid #38424b
    }

    .dark .list-unstyled-border li {
        border-bottom: 1px solid #616161
    }

    .dark .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, .06)
    }

    .dark table.dataTable thead th {
        border-bottom: 1px solid #343b44 !important
    }

    .dark table.dataTable thead td {
        border-bottom: 1px solid #343b44 !important
    }

    .dark .media .media-title {
        color: #96a2b4
    }

    .dark .media .media-title a {
        color: #96a2b4
    }

    .dark .media .media-right {
        color: #96a2b4
    }

    .dark.main-sidebar .sidebar-menu li ul.dropdown-menu li.active>a {
        color: #f1d065
    }

    .dark.main-sidebar .sidebar-menu li ul.dropdown-menu li.active>a:before {
        color: #f1d065
    }

    .dark.main-sidebar .sidebar-menu li ul.dropdown-menu li a:hover {
        color: #f1d065
    }

    .dark.main-sidebar .sidebar-menu li ul.dropdown-menu li a:hover:before {
        color: #f1d065
    }

    .dark .profile-widget .profile-widget-items .profile-widget-item .profile-widget-item-label {
        color: #96a2b4
    }

    .dark .profile-widget .profile-widget-items .profile-widget-item .profile-widget-item-value {
        color: #96a2b4
    }

    .dark .user-item .user-details .user-name {
        color: #96a2b4
    }

    .dark .gradient-bottom:after {
        background-image: none
    }

    .dark .buttons .btn {
        box-shadow: none
    }

    .dark .btn-group>.btn {
        box-shadow: none
    }

    .dark .btn-group-vertical>.btn {
        box-shadow: none
    }

    .dark .chat-box .chat-content {
        background-color: #353c48 !important
    }

    .dark .chat-box .chat-content .chat-text {
        background-color: #1f1e1e !important
    }

    .dark .people-list .chat-list li.active {
        background: #1f1e1e
    }

    .dark .people-list .chat-list li:hover {
        background: #1f1e1e
    }

    .dark .custom-switch-input:checked~.custom-switch-description {
        color: #f5f7f9
    }

    .dark .form-group>label {
        color: #96a2b4
    }

    .dark input.form-control {
        color: #96a2b4
    }

    .dark input.form-control:focus {
        border-color: #b9b9b9
    }

    .dark select.form-control {
        color: #96a2b4
    }

    .dark select.form-control:focus {
        border-color: #b9b9b9
    }

    .dark .fc-view>table td {
        color: #fff
    }

    .dark .max-texts a {
        color: #96a2b4
    }

    .dark .table-hover tbody tr:hover {
        color: #96a2b4
    }

    .dark .author-box .author-box-job {
        color: #96a2b4
    }

    .dark .wizard>.steps .disabled a {
        background: #32363c;
        color: #96a2b4
    }

    .dark .activities .activity .activity-detail {
        background-color: #353c48
    }

    .dark .statistic-details .statistic-details-item .detail-name {
        color: #96a2b4
    }

    .dark .to-do-list li {
        background-color: #353c48
    }

    .dark .form-check {
        color: #96a2b4
    }

    .dark .form-check .form-check-sign .check {
        border: 1px solid rgba(228, 224, 224, .54)
    }

    .dark #visitorMap,
    .dark #visitorMap2,
    .dark #visitorMap3,
    .dark #visitorMap4 {
        background-color: #353c48 !important
    }

    .dark .note-editor.note-frame .note-editing-area .note-editable {
        background-color: #353c48;
        color: #96a2b4
    }

    .dark .note-editor.note-frame .note-toolbar button {
        color: #96a2b4
    }

    .dark .info-card {
        color: #fff
    }

    .dark .info-card P {
        color: #fff !important
    }

    .dark .accordion .accordion-header {
        background-color: #0e0e0e;
        box-shadow: none
    }

    .dark .modal-content {
        background-color: #000
    }

    .dark .nav-tabs .nav-item .nav-link {
        color: #96a2b4
    }
</style>


@section('content')
<div class="content-wrapper">
    <div class="row">

        <div class="col-xl-3 col-lg-6">

            <div class="card l-bg-green-dark hover">
                <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('admin.carrerListing') }}">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
                        <div class="card-content">
                            <h4 class="card-title">Contact Us</h4>

                            <div class="d-flex justify-content-between">
                                <span><b>Count : {{ $contactus }} </b><b></b></span>
                            </div>

                            <p class="mb-0 text-sm">
                                <span class="text-nowrap">See More</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6">

            <div class="card l-bg-cyan-dark hover">
                <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('admin.listing') }}">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-briefcase"></i></div>
                        <div class="card-content">
                            <h4 class="card-title">Carrer</h4>

                            <div class="d-flex justify-content-between">
                                <span><b>Count : {{ $carrers }} </b><b></b></span>
                            </div>

                            <p class="mb-0 text-sm">
                                <span class="text-nowrap">See More</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6">

            <div class="card l-bg-purple-dark hover">
                <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('admin.appointmentsListing') }}">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
                        <div class="card-content">
                            <h4 class="card-title">Appointments</h4>

                            <div class="d-flex justify-content-between">
                                <span><b>Count : {{ $appointments }} </b><b></b></span>
                            </div>


                            <p class="mb-0 text-sm">
                                <span class="text-nowrap">See More</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        <div class="col-xl-3 col-lg-6">

            <div class="card l-bg-orange-dark hover">
                <a style="font-weight:bold;color:white;text-decoration:none;" href="{{ route('admin.collaborationListing') }}">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
                        <div class="card-content">
                            <h4 class="card-title">Collaboration</h4>

                            <div class="d-flex justify-content-between">
                                <span><b>Count : {{ $collaborations }} </b><b></b></span>
                            </div>

                            <p class="mb-0 text-sm">
                                <span class="text-nowrap">See More</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
</div>
@endsection



2. Add Controller Side Code 

use Mockery\CountValidator\Exact;

public function home()
  {

    $admins = Admin::count();
    $contactus = Contact::count();
    $carrers = DB::table('careers')->count();
    $appointments = DB::table('appointments')->count();
    $collaborations = DB::table('collaborations')->count();
    $faqs_getting_started = DB::table('faqs_getting_started')->count();
    $faqs_payment = DB::table('faqs_payment')->count();
    $faqs_returns = DB::table('faqs_returns')->count();
    $faqs_shipping = DB::table('faqs_shipping')->count();
    $blogs = DB::table('blogs')->count();
    

    // dd($admins, $carrers, $appointments, $collaborations, $faqs_getting_started, $faqs_payment, $faqs_returns, $faqs_shipping, $blogs, $contactus);

    
    return view('admin.dashboard', compact('admins', 'carrers', 'appointments', 'collaborations','faqs_getting_started', 'faqs_payment',   'faqs_returns', 'faqs_shipping','blogs', 'contactus'));
  }