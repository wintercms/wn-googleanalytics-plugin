# Upgrade guide

- [Upgrade guide](#upgrade-guide)
  - [Upgrading To 1.1](#upgrading-to-11)

<a name="upgrade-1.1"></a>
## Upgrading To 1.1

The settings and instructions for authorizing Google have been drastically simplified. For existing accounts, you will need to generate a new key file using these steps:

1. Log in to the [Google Developers Console](https://console.developers.google.com/home/dashboard) and search for **Service Accounts**
1. If you need to create a new Service Account, click on the **Create Service Account** at the top and then add a name and click on **Create**.
1. You should see an account in the **Service Accounts** list and click the menu in the **Actions** column and select **Manage key**.
1. Choose the **Key type** of `JSON`.
1. Download the file to your computer and upload it to the Winter CMS back-end settings form.

The Profile ID number has also changed, follow these settings to find the new one:

1. In a new tab, navigate to the main [Google Analytics site](https://www.google.com/analytics/web/) and select the property you want to track.
1. Click the **Admin** main menu tab again and select **View > View Settings** from the menu. *Copy to your clipboard* the Profile ID (should be a number).
1. Paste this number in the **Analytics View/Profile ID number** field in the Winter CMS back-end settings form.

> **Note**: This plugin does not support GAv4. If you are having issues creating an account, use the **Show advanced options** link in the GA Account creation and the **Create a Universal Analytics property** switch.